<?php

/**
 * BFL Attributemapping
 *
 * @category   Attributemapping Module
 * @package    BFL Attributemapping
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Attributemapping\Model;

use Magento\Framework\Api\DataObjectHelper;
use Cybage\Attributemapping\Api\Data\AttributesInterface;
use Cybage\Attributemapping\Api\Data\AttributesInterfaceFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Attributes extends \Magento\Framework\Model\AbstractModel {

    protected $_eventPrefix = 'cybage_attributemapping_attributes';
    protected $attributesDataFactory;
    protected $dataObjectHelper;

    const ROW_COUNT = 17;

    /**
     * CSV Processor
     *
     * @var \Magento\Framework\File\Csv
     */
    protected $csvProcessor;

    /**
     * Constructor
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param AttributesInterfaceFactory $attributesDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Cybage\Attributemapping\Model\ResourceModel\Attributes $resource
     * @param \Cybage\Attributemapping\Model\ResourceModel\Attributes\Collection $resourceCollection
     * @param \Magento\Framework\File\Csv $csvProcessor
     * @param \Magento\Framework\Filesystem\DirectoryList $dir
     * @param \Cybage\Attributemapping\Model\Import $import
     * @param ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Filesystem\Io\File $filesystemIo
     * @param array $data
     */
    public function __construct(
    \Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, AttributesInterfaceFactory $attributesDataFactory, DataObjectHelper $dataObjectHelper, \Cybage\Attributemapping\Model\ResourceModel\Attributes $resource, \Cybage\Attributemapping\Model\ResourceModel\Attributes\Collection $resourceCollection, \Magento\Framework\File\Csv $csvProcessor, \Magento\Framework\Filesystem\DirectoryList $dir, \Cybage\Attributemapping\Model\Import $import, ScopeConfigInterface $scopeConfig, \Magento\Framework\Filesystem\Io\File $filesystemIo, \Magento\Framework\Filesystem\Io\Sftp $sftp, \Magento\Framework\Filesystem $fileSystem, array $data = []
    ) {
        $this->attributesDataFactory = $attributesDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->csvProcessor = $csvProcessor;
        $this->_dir = $dir;
        $this->import = $import;
        $this->scopeConfig = $scopeConfig;
        $this->filesystemIo = $filesystemIo;
        $this->sftp = $sftp;
        $this->_fileSystem = $fileSystem;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve attributes model with attributes data
     * @return AttributesInterface
     */
    public function getDataModel() {
        $attributesData = $this->getData();

        $attributesDataObject = $this->attributesDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
                $attributesDataObject, $attributesData, AttributesInterface::class
        );

        return $attributesDataObject;
    }

    public function readCsv() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORES;
        $isEnabled = $this->scopeConfig->getValue("cybage/attributemapping/enable", $storeScope);

        if ($isEnabled) {
            //Host information
//            $hostname = $this->scopeConfig->getValue("cybage/sftp/hostname", $storeScope);
//            $username = $this->scopeConfig->getValue("cybage/sftp/username", $storeScope);
//            $password = $this->scopeConfig->getValue("cybage/sftp/password", $storeScope);
            $fileAbsolutePath = $this->scopeConfig->getValue("cybage/sftp/filepath", $storeScope);
            $fileName = $this->scopeConfig->getValue("cybage/sftp/filename", $storeScope);
            $filePath = $fileAbsolutePath . '/' . $fileName;
            /* $this->sftp->open(
                    array(
                        'host' => $hostname,
                        'username' => $username,
                        'password' => $password
                    )
            ); */
            //$importProductRawData = $this->sftp->read($filePath);
            /* if ($importProductRawData === FALSE) {
                $this->writeLog("Csv file does not exist on host.");
                exit;
            } */
            /*$dir = $this->_dir->getPath('var') . "/WL/";
            if (!is_dir($dir)) {
                mkdir($dir, 0777);
            }*/

            //$mediaFile = $dir . $fileName;
            $mediaFile = $filePath;
            //$fp = fopen($mediaFile, 'w');
            //fwrite($fp, $importProductRawData);
            //fclose($fp);
            
            if (file_exists($mediaFile)) {
                $importProductRawData = $this->csvProcessor->getData($mediaFile);
                $isValid = $this->validateCsv($importProductRawData);
                if ($isValid) {
                    foreach ($importProductRawData as $rowIndex => $dataRow) {
                        if ($rowIndex === 0) {
                            continue;
                        }
                        $this->import->saveCsvData($dataRow);
                    }
                    //Remove file from local server
                    $this->filesystemIo->rm($mediaFile);
                    //Archive file from host server
                    //$this->sftp->mkdir('/archive');
                    $copyFileFullPath = $fileAbsolutePath . "/archive/" . $fileName;
                    //$this->sftp->mv($filePath, $copyFileFullPath);
                    $this->writeLog("Csv imported successfully.");
                } else {
                    //Archive failed file
                    //$this->sftp->mkdir('/failed');
                    $copyFileFullPath = $fileAbsolutePath . "/archive/" . $fileName;
                    //$this->sftp->mv($filePath, $copyFileFullPath);
                    $this->writeLog("Csv import failed.");
                }
            } else {
                $this->writeLog("Csv file does not exist.");
            }
        } else {
            $this->writeLog("Import disabled from admin panel.");
        }
    }

    /**
     * Function to validate csv
     * @param type $importProductRawData
     */
    public function validateCsv($importProductRawData) {
        $rowCount = count($importProductRawData[0]);
        if ($rowCount == self::ROW_COUNT) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function writeLog($param) {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/csvimport.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("CSV Import", array('Message', $param, true));
    }

}
