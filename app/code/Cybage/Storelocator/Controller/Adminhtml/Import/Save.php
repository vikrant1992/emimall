<?php

/**
 * BFL Cybage_Storelocator
 *
 * @category   Cybage_Storelocator
 * @package    BFL Cybage_Storelocator
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Storelocator\Controller\Adminhtml\Import;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\File\Csv;
use Magento\Backend\App\Action\Context;

class Save extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Cybage_Storelocator::import';

    /**
     * Constructor
     * 
     * @param Context $context
     * @param \Zend_File_Transfer $zend
     * @param Csv $csvProcessor
     * @param \Cybage\Storelocator\Model\DealerFactory $dealerFactory
     * @param \Cybage\Storelocator\Model\CityFactory $cityFactory
     * @param \Cybage\Storelocator\Model\DealergroupFactory $groupFactory
     * @param \Cybage\Storelocator\Model\DealercategoryFactory $dealerCategoryFactory
     * @param \Cybage\Storelocator\Model\OfferFactory $offerFactory
     * @param \Cybage\Storelocator\Model\OffertypeFactory $offertypeFactory
     */
    public function __construct(
        Context $context,
        \Zend_File_Transfer $zend,
        Csv $csvProcessor,
        \Cybage\Storelocator\Model\DealerFactory $dealerFactory,
        \Cybage\Storelocator\Model\CityFactory $cityFactory,
        \Cybage\Storelocator\Model\DealergroupFactory $groupFactory,
        \Cybage\Storelocator\Model\DealercategoryFactory $dealerCategoryFactory,
        \Cybage\Storelocator\Model\OfferFactory $offerFactory,
        \Cybage\Storelocator\Model\OffertypeFactory $offertypeFactory,
        \Magento\Framework\App\ResourceConnection $resourceconnection
    ) {
        $this->_zend = $zend;
        $this->csvProcessor = $csvProcessor;
        $this->dealerFactory = $dealerFactory;
        $this->cityFactory = $cityFactory;
        $this->groupFactory = $groupFactory;
        $this->dealerCategoryFactory = $dealerCategoryFactory;
        $this->offerFactory = $offerFactory;
        $this->offertypeFactory = $offertypeFactory;
        $this->connection = $resourceconnection;
        parent::__construct($context);
    }

    /**
     * Validating and importing csv
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRedirectUrl());
        $filesUploadCheck = $this->_zend->__call('getFileInfo', []);
        if (isset($filesUploadCheck) && !empty($filesUploadCheck['import_dealer_file']['tmp_name'])) {
            $this->validateDealerImportFile($filesUploadCheck);
        }
        if (isset($filesUploadCheck) && !empty($filesUploadCheck['import_city_file']['tmp_name'])) {
            $this->validateCityImportFile($filesUploadCheck);
        }
        if (isset($filesUploadCheck) && !empty($filesUploadCheck['import_group_file']['tmp_name'])) {
            $this->validateDealerGroupImportFile($filesUploadCheck);
        }
        if (isset($filesUploadCheck) && !empty($filesUploadCheck['import_oem_file']['tmp_name'])) {
            $this->validateDealerOemImportFile($filesUploadCheck);
        }
        if (isset($filesUploadCheck) && !empty($filesUploadCheck['import_offer_file']['tmp_name'])) {
            $this->validateDealerOfferImportFile($filesUploadCheck);
        }
        if (isset($filesUploadCheck) && !empty($filesUploadCheck['import_offertype_file']['tmp_name'])) {
            $this->validateDealerOffertypeImportFile($filesUploadCheck);
        }
        if (isset($filesUploadCheck) && !empty($filesUploadCheck['import_dealer_flag_file']['tmp_name'])) {
            $this->validateDealerFlagImportFile($filesUploadCheck);
        }
        
        return $resultRedirect;
    }

    /**
     * Import dealer data
     *
     * @param type $result
     */
    public function processDealerUpload($result)
    {
        $sourceFile = $result['import_dealer_file']['tmp_name'];
        $rows = $this->csvProcessor->getData($sourceFile);
        foreach ($rows as $rowIndex => $dataRow) {
            if ($rowIndex === 0) {
                continue;
            }
            $dealerModel = $this->dealerFactory->create()->load($dataRow[1], 'bajaj_dealerid');
            $dealerModel->setGroupId($dataRow[0]);
            $dealerModel->setAddress($dataRow[4]);
            $dealerModel->setCityId($dataRow[2]);
            $dealerModel->setPhone($dataRow[9]);
            $dealerModel->setBajajDealerid($dataRow[1]);
            $dealerModel->setDealerName($dataRow[3]);
            $dealerModel->setArea($dataRow[5]);
            $dealerModel->setPincode($dataRow[6]);
            $dealerModel->setLatitude($dataRow[7]);
            $dealerModel->setLongitude($dataRow[8]);
            $dealerModel->setIsActive($dataRow[10]);
            $dealerModel->setSubcategories($dataRow[11]);
            $dealerModel->setLob($dataRow[12]);
            $dealerModel->setHexacode($dataRow[13]);
            $dealerModel->save();
        }
    }

    /**
     * Validate dealer csv
     * @param type $filesUploadCheck
     * @return type
     */
    public function validateDealerImportFile($filesUploadCheck)
    {
        $fileName = $filesUploadCheck['import_dealer_file']['name'];
        $linecounter = 0;
        $fh = fopen($filesUploadCheck['import_dealer_file']['tmp_name'], 'rb') or die("ERROR OPENING DATA");
        while (fgets($fh) !== false) {
            $linecounter++;
        }
        $extension = pathinfo($filesUploadCheck['import_dealer_file']['name'], PATHINFO_EXTENSION);
        if ($extension != 'csv') {
            $this->messageManager->addError(__($fileName . 'File should be csv.'));
        } else {
            $this->processDealerUpload($filesUploadCheck);
            $this->messageManager->addSuccess(__('Dealers impoted successfully.'));
        }
    }

    /**
     * Import cities
     * @param type $result
     */
    public function processCityUpload($result)
    {
        $sourceFile = $result['import_city_file']['tmp_name'];
        $rows = $this->csvProcessor->getData($sourceFile);
        foreach ($rows as $rowIndex => $dataRow) {
            if ($rowIndex === 0) {
                continue;
            }
            $cityModel = $this->cityFactory->create()->load($dataRow[1], 'bajaj_city_id');
            $cityModel->setCityName($dataRow[0]);
            $cityModel->setBajajCityId($dataRow[1]);
            $cityModel->setCityLatitude($dataRow[2]);
            $cityModel->setCityLongitude($dataRow[3]);
            $cityModel->save();
        }
    }

    /**
     * Validate city csv
     * @param type $filesUploadCheck
     * @return type
     */
    public function validateCityImportFile($filesUploadCheck)
    {
        $fileName = $filesUploadCheck['import_city_file']['name'];
        $linecounter = 0;
        $fh = fopen($filesUploadCheck['import_city_file']['tmp_name'], 'rb') or die("ERROR OPENING DATA");
        while (fgets($fh) !== false) {
            $linecounter++;
        }
        $extension = pathinfo($filesUploadCheck['import_city_file']['name'], PATHINFO_EXTENSION);
        if ($extension != 'csv') {
            $this->messageManager->addError(__($fileName . 'File should be csv.'));
        } else {
            $this->processCityUpload($filesUploadCheck);
            $this->messageManager->addSuccess(__('Cities impoted successfully.'));
        }
    }

    /**
     * Import groups
     * @param type $result
     */
    public function processGroupUpload($result)
    {
        $sourceFile = $result['import_group_file']['tmp_name'];
        $rows = $this->csvProcessor->getData($sourceFile);
        foreach ($rows as $rowIndex => $dataRow) {
            if ($rowIndex === 0) {
                continue;
            }
            $groupModel = $this->groupFactory->create()->load($dataRow[0], 'group_id');
            $groupModel->setGroupId($dataRow[0]);
            $groupModel->setStoreName($dataRow[1]);
            $groupModel->save();
        }
    }

    /**
     * Validate groups csv
     * @param type $filesUploadCheck
     * @return type
     */
    public function validateDealerGroupImportFile($filesUploadCheck)
    {
        $fileName = $filesUploadCheck['import_group_file']['name'];
        $linecounter = 0;
        $fh = fopen($filesUploadCheck['import_group_file']['tmp_name'], 'rb') or die("ERROR OPENING DATA");
        while (fgets($fh) !== false) {
            $linecounter++;
        }
        $extension = pathinfo($filesUploadCheck['import_group_file']['name'], PATHINFO_EXTENSION);
        if ($extension != 'csv') {
            $this->messageManager->addError(__($fileName . 'File should be csv.'));
        } else {
            $this->processGroupUpload($filesUploadCheck);
            $this->messageManager->addSuccess(__('Groups impoted successfully.'));
        }
    }

    /**
     * Import oem
     * @param type $result
     */
    public function processOemUpload($result)
    {
        $sourceFile = $result['import_oem_file']['tmp_name'];
        $rows = $this->csvProcessor->getData($sourceFile);
        foreach ($rows as $rowIndex => $dataRow) {
            if ($rowIndex === 0) {
                continue;
            }
            $oemModel = $this->dealerCategoryFactory->create()->load($dataRow[0], 'dealer_id');
            $oemModel->setDealerId($dataRow[0]);
            $oemModel->setOemId($dataRow[1]);
            $oemModel->setOemName($dataRow[2]);
            $oemModel->setSubcategoryId($dataRow[3]);
            $oemModel->save();
        }
    }

    /**
     * Validate oem csv
     * @param type $filesUploadCheck
     * @return type
     */
    public function validateDealerOemImportFile($filesUploadCheck)
    {
        $fileName = $filesUploadCheck['import_oem_file']['name'];
        $linecounter = 0;
        $fh = fopen($filesUploadCheck['import_oem_file']['tmp_name'], 'rb') or die("ERROR OPENING DATA");
        while (fgets($fh) !== false) {
            $linecounter++;
        }
        $extension = pathinfo($filesUploadCheck['import_oem_file']['name'], PATHINFO_EXTENSION);
        if ($extension != 'csv') {
            $this->messageManager->addError(__($fileName . 'File should be csv.'));
        } else {
            $this->processOemUpload($filesUploadCheck);
            $this->messageManager->addSuccess(__('OEM impoted successfully.'));
        }
    }

    /**
     * Import offers
     * @param type $result
     */
    public function processOfferUpload($result)
    {
        $sourceFile = $result['import_offer_file']['tmp_name'];
        $rows = $this->csvProcessor->getData($sourceFile);
        foreach ($rows as $rowIndex => $dataRow) {
            if ($rowIndex === 0) {
                continue;
            }
            $offerModel = $this->offerFactory->create()->load($dataRow[1], 'dealerofferid');
            $offerModel->setDealerid($dataRow[0]);
            $offerModel->setDealerofferid($dataRow[1]);
            $offerModel->setOfferText($dataRow[2]);
            $offerModel->save();
        }
    }

    /**
     * Validate offer csv
     * @param type $filesUploadCheck
     * @return type
     */
    public function validateDealerOfferImportFile($filesUploadCheck)
    {
        $fileName = $filesUploadCheck['import_offer_file']['name'];
        $linecounter = 0;
        $fh = fopen($filesUploadCheck['import_offer_file']['tmp_name'], 'rb') or die("ERROR OPENING DATA");
        while (fgets($fh) !== false) {
            $linecounter++;
        }
        $extension = pathinfo($filesUploadCheck['import_offer_file']['name'], PATHINFO_EXTENSION);
        if ($extension != 'csv') {
            $this->messageManager->addError(__($fileName . 'File should be csv.'));
        } else {
            $this->processOfferUpload($filesUploadCheck);
            $this->messageManager->addSuccess(__('Offers impoted successfully.'));
        }
    }

    /**
     * Import offers
     * @param type $result
     */
    public function processOffertypeUpload($result)
    {
        $sourceFile = $result['import_offertype_file']['tmp_name'];
        $rows = $this->csvProcessor->getData($sourceFile);
        foreach ($rows as $rowIndex => $dataRow) {
            if ($rowIndex === 0) {
                continue;
            }
            $offertypeModel = $this->offertypeFactory->create()->load($dataRow[0], 'offerid');
            $offertypeModel->setOfferid($dataRow[0]);
            $offertypeModel->setOfferType($dataRow[1]);
            $offertypeModel->save();
        }
    }

    /**
     * Validate offer type csv
     * @param type $filesUploadCheck
     * @return type
     */
    public function validateDealerOffertypeImportFile($filesUploadCheck)
    {
        $fileName = $filesUploadCheck['import_offertype_file']['name'];
        $linecounter = 0;
        $fh = fopen($filesUploadCheck['import_offertype_file']['tmp_name'], 'rb') or die("ERROR OPENING DATA");
        while (fgets($fh) !== false) {
            $linecounter++;
        }
        $extension = pathinfo($filesUploadCheck['import_offertype_file']['name'], PATHINFO_EXTENSION);
        if ($extension != 'csv') {
            $this->messageManager->addError(__($fileName . 'File should be csv.'));
        } else {
            $this->processOffertypeUpload($filesUploadCheck);
            $this->messageManager->addSuccess(__('Offer type impoted successfully.'));
        }
    }
    
    /**
     * Validate dealer flag csv
     * @param type $filesUploadCheck
     * @return type
     */
    public function validateDealerFlagImportFile($filesUploadCheck)
    {
        $fileName = $filesUploadCheck['import_dealer_flag_file']['name'];
        $linecounter = 0;
        $fh = fopen($filesUploadCheck['import_dealer_flag_file']['tmp_name'], 'rb') or die("ERROR OPENING DATA");
        while (fgets($fh) !== false) {
            $linecounter++;
        }
        $extension = pathinfo($filesUploadCheck['import_dealer_flag_file']['name'], PATHINFO_EXTENSION);
        if ($extension != 'csv') {
            $this->messageManager->addError(__($fileName . 'File should be csv.'));
        } else {
            $this->processDealerFlagUpload($filesUploadCheck);
            $this->messageManager->addSuccess(__('Dealer flag updated successfully.'));
        }
    }
    
    /**
     * Import dealer flag
     * @param type $result
     */
    public function processDealerFlagUpload($result) {
        $sourceFile = $result['import_dealer_flag_file']['tmp_name'];
        $rows = $this->csvProcessor->getData($sourceFile);
        $dataRow = implode(",", $rows[0]);
        $resConnection = $this->connection->getConnection();
        $tableName = $resConnection->getTableName('cybage_storelocator_dealer');
        $sql = "Update " . $tableName . " set sfdc = '1' where bajaj_dealerid IN (" . $dataRow . ")";
        $resConnection->query($sql);
    }

}
