<?php

/**
 * BFL Cybage_ImportReview
 *
 * @category   Cybage_ImportReview
 * @package    BFL Cybage_ImportReview
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\ImportReview\Controller\Adminhtml\Import;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\File\Csv;
use Magento\Backend\Model\Auth\Session;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\Product;
use Magento\Review\Model\ReviewFactory;
use Magento\Store\Model\StoreManager;
use Magento\Review\Model\ResourceModel\Review\CollectionFactory as ReviewCollectionFactory;
use Magento\Review\Model\RatingFactory;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Filesystem\Io\File as FileIO;
use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magento\Backend\App\Action {

    const ADMIN_RESOURCE = 'Cybage_ImportReview::import_customer_review_product';

    /**
     *
     * @var Zend
     */
    protected $_zend;

    /**
     * Csv  
     */
    protected $csvProcessor;
    
    /**
     * @var File 
     */
    protected $_file;
    
    /**
     * @var FileIO
     */
    protected $fileIo;
    
    /**
     * @var DirectoryList 
     */
    protected $directoryList;


    /**
     * @param Context $context
     * @param \Zend_File_Transfer $zend
     * @param Csv $csvProcessor
     * @param Session $authSession
     * @param Product $productManager
     * @param ReviewFactory $reviewFactory
     * @param StoreManager $storeManager
     * @param ReviewCollectionFactory $reviewCollectionFactory
     * @param RatingFactory $ratingFactory
     * @param File $file
     * @param FileIO $fileIo
     * @param DirectoryList $directoryList
     */
    public function __construct(
        Context $context, 
        \Zend_File_Transfer $zend, 
        Csv $csvProcessor, 
        Session $authSession,
        Product $productManager,
        ReviewFactory $reviewFactory,
        StoreManager $storeManager,
        ReviewCollectionFactory $reviewCollectionFactory,
        RatingFactory $ratingFactory,
        File $file,
        FileIO $fileIo,
        DirectoryList $directoryList
    ) {
        $this->authSession = $authSession;
        $this->_zend = $zend;
        $this->csvProcessor = $csvProcessor;
        $this->productManager = $productManager;
        $this->reviewFactory = $reviewFactory;
        $this->storeManager = $storeManager;
        $this->reviewCollectionFactory = $reviewCollectionFactory;
        $this->ratingFactory = $ratingFactory;
        $this->_file = $file;
        $this->fileIo = $fileIo;
        $this->directoryList = $directoryList;
        parent::__construct($context);
    }

    /**
     * Vallidating and importing csv
     */
    public function execute() {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRedirectUrl());
        $filesUploadCheck = $this->_zend->__call('getFileInfo', []);
        if (isset($filesUploadCheck) && !empty($filesUploadCheck['import_file']['tmp_name'])) {
            $fileName = $filesUploadCheck['import_file']['name'];

            $linecounter = 0;
            $fh = fopen($filesUploadCheck['import_file']['tmp_name'], 'rb') or die("ERROR OPENING DATA");
            while (fgets($fh) !== false){
                $linecounter++;
            }

            $extension = pathinfo($filesUploadCheck['import_file']['name'], PATHINFO_EXTENSION);

            if ($extension != 'csv') {
                $this->messageManager->addError(__('File should be csv.'));
                return $resultRedirect;
            }
            $this->processUpload($filesUploadCheck, $resultRedirect);
            
            $this->messageManager->addSuccess( __('You saved the review') );
            return $resultRedirect;            
        } else {
            $this->messageManager->addError(__('File is not present.'));
            return $resultRedirect;
        }
    }
    
    /**
     * Parsing uploaded csv file
     *
     * @param [type] $result
     * @return void
     */
    public function processUpload( $result, $resultRedirect ) {
        $errors = [];
        $sourceFile = $result['import_file']['tmp_name'];
        $rows = $this->csvProcessor->getData($sourceFile);
        $header = array_shift($rows);
        $errors = $this->validateCsvData($rows);
        if(count($errors) > 0){
            $fileLogPathSummary = $this->createCsvFile($errors, $result);
            $this->messageManager->addError(__('CSV file contains some invalid data, please download ' . '<a href="' . $fileLogPathSummary . '" target="_blank" >error log</a>'.' to check error reason'));
            return $resultRedirect;
        }
        // See \Magento\ReviewSampleData\Model\Review::install()
        foreach ($rows as $row) {

            $data = [];
            foreach ($row as $key => $value) {
                $data[trim($header[$key])] = $value;
            }

            if($data['status'] == 0 || $data['status'] == ""){
                $this->messageManager->addError('Status can\'t be empty or 0');
                return $resultRedirect;
            }
            $row = $data;
            
            $row['rating_code'] = 'Rating'; // Fixed to "Rating" for now
            
            //If product id is used as sku
            $productId = $this->productManager->getIdBySku($row['product_sku']);
            $row['product'] = $productId;
            if (empty($productId)) {
                continue;
            }
            $review = $this->prepareReview($row);
            
            /** @var \Magento\Review\Model\ResourceModel\Review\Collection $reviewCollection */
            $review->save();
            $this->setReviewRating($review, $row);
        }
    }
    
    /** 
     * Create review attribute data
     * 
     * @param array $row
     * @return \Magento\Review\Model\Review
     */
    protected function prepareReview( $row ){
        /** @var $review \Magento\Review\Model\Review */
        $storeId = $this->storeManager->getStore()->getId();
        $review = $this->reviewFactory->create();
        $review->setEntityId(
            $review->getEntityIdByCode(\Magento\Review\Model\Review::ENTITY_PRODUCT_CODE)
        )->setEntityPkValue(
            $row['product']
        )->setNickname(
            $row['nickname']
        )->setTitle(
            $row['summary']
        )->setDetail(
            $row['detail']
        )->setStatusId(
            $row['status']
        )->setStoreId(
            $storeId
        )->setStores(
            [$storeId]
        )->setCreatedAt(
            $this->formatDate($row['created_at'])
        );
        return $review;
    }
    
    /**
     * Converts date to mysql formatted date
     *
     * @param string $date
     * @return string converted date
     */
    public function formatDate($date){
        $timestamp = strtotime($date);
        return date("Y-m-d H:i:s", $timestamp);
    }
    
    /**
     * @return int review ID
     */
    protected function getReviewEntityId(){
        $review = $this->reviewFactory->create();
        return $review->getEntityIdByCode(\Magento\Review\Model\Review::ENTITY_PRODUCT_CODE);
    }
    
    /**
     * @param \Magento\Review\Model\Review $review
     * @param array $row
     * @return void
     */
    protected function setReviewRating(\Magento\Review\Model\Review $review, $row){
        $rating = $this->getRating($row['rating_code']);
        foreach ($rating->getOptions() as $option) {
            $optionId = $option->getOptionId();
            if (($option->getValue() == $row['stars']) && !empty($optionId)) {
                $rating->setReviewId($review->getId())
                        ->addOptionVote($optionId, $row['product']);
            }
        }
        $review->aggregate();
    }
    
    /**
     * @param string $rating
     * @return array
     */
    protected function getRating($rating){
        $ratingCollection = $this->ratingFactory->create()->getResourceCollection();
        $ratings[$rating] = $ratingCollection->addFieldToFilter('rating_code', $rating)->getFirstItem();
        return $ratings[$rating];
    }
    
    
    /**
     * Validate CSV Data
     * @param array $rows
     */
    public function validateCsvData($rows) {
        $line = 1;
        $errors= [];
        foreach($rows as $row){
           foreach($row as $key => $val){
               if(empty($val) || $val ==""){
                   if($key == 6 && $val == 0){
                       $errorMsg = "Invalid vlaue at column ".$key." for row". $line;
                   }
                   $errorMsg = "Invalid vlaue at column ".$key." for row". $line;
                   $errors[] = [$errorMsg];
               }
           }
           $line++;
        }
        return $errors;
    }
    
    /**
     * Download Path for csv
     * @param string $file
     */
    public function downloadCsv($file)
    {
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();flush();
            readfile($file);
        }
    }
    
    public function createCsvFile($data, $uploadedCsvFile) {
        if (!empty($data) && !empty($uploadedCsvFile)) {
            $uploadedfileName = $uploadedCsvFile['import_file']['name'];
            $fileData = pathinfo($uploadedfileName);
            $extension = $fileData['extension'];
            $imgFileName = $fileData['filename'];
            $str = preg_replace("/\W+/", '_', trim($imgFileName));
            $finalFileName = $str . '.' . $extension;
            $timeStamp = microtime(true);
            $fileDirectoryPath = $this->directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
            $dirPath = '/cybage/reviews/ImportReviews_'.$timeStamp.'/';
            $filDir = '/cybage/reviews/ImportReviews_'.$timeStamp.'/';
            $filePath = $fileDirectoryPath.$dirPath;
            if (!$this->_file->isDirectory($filePath)) {
                $this->fileIo->checkAndCreateFolder($filePath, 0775);
            }
            $filePathDownload = $filePath . $finalFileName;
            $baseUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
            $fileUrl = $baseUrl .$filDir.$finalFileName;
            $this->csvProcessor
                    ->setEnclosure('"')
                    ->setDelimiter(',')
                    ->saveData($filePathDownload, $data);
            return $fileUrl;
        }
    }
}
