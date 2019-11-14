<?php

/**
 * BFL Storelocator
 *
 * @category   Storelocator Module
 * @package    BFL Storelocator
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Storelocator\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Magento\Framework\Filesystem\DirectoryList;

class Dealerimport extends Command
{

    const FILE_PATH = "file";

    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * Constructor
     *
     * @param \Magento\Framework\File\Csv $csvProcessor
     * @param \Cybage\Storelocator\Model\DealerFactory $dealerFactory
     * @param \Cybage\Storelocator\Console\Command\DirectoryList $directoryList
     */
    public function __construct(
        \Magento\Framework\File\Csv $csvProcessor,
        \Cybage\Storelocator\Model\DealerFactory $dealerFactory,
        DirectoryList $directoryList
    ) {
        $this->csvProcessor = $csvProcessor;
        $this->dealerFactory = $dealerFactory;
        $this->directoryList = $directoryList;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $path = $input->getArgument(self::FILE_PATH);
        $this->validateDealerImportFile($path, $output);
    }

    /**
     * Validate dealer csv
     * @param type $path
     * @return type
     */
    public function validateDealerImportFile($path, $output)
    {
        $rootPath = $this->directoryList->getRoot();
        $importFile = $rootPath . '/' . $path;

        $linecounter = 0;
        $fh = fopen($importFile, 'rb') or die("ERROR OPENING DATA");
        while (fgets($fh) !== false) {
            $linecounter++;
        }
        $extension = pathinfo($importFile, PATHINFO_EXTENSION);
        if ($extension != 'csv') {
            echo __('File should be csv.');
        } else {
            $this->processDealerUpload($importFile, $output);
            echo __('Dealers impoted successfully.');
        }
    }

    /**
     * Import Dealer
     * @param type $importFile
     */
    public function processDealerUpload($importFile, $output)
    {
        $rows = $this->csvProcessor->getData($importFile);
        $header = array_shift($rows);
        $count = count($rows);
        $output->writeln('Import started...!');
        $progressBar = new ProgressBar($output, $count);
        $progressBar->start();
        foreach ($rows as $dataRow) {
            $data = [];
            foreach ($dataRow as $key => $value) {
                $data[trim($header[$key])] = $value;
            }
            $dealerModel = $this->dealerFactory->create()->load($data['dealer_id'], 'bajaj_dealerid');
            $dealerModel->setGroupId($data['group_id']);
            $dealerModel->setAddress($data['address']);
            $dealerModel->setCityId($data['city_id']);
            $dealerModel->setPhone($data['phone_no']);
            $dealerModel->setBajajDealerid($data['dealer_id']);
            $dealerModel->setDealerName($data['dealer_name']);
            $dealerModel->setArea($data['area']);
            $dealerModel->setPincode($data['pincode']);
            $dealerModel->setLatitude($data['latitude']);
            $dealerModel->setLongitude($data['longitude']);
            $dealerModel->setIsActive($data['isactive']);
            $dealerModel->setLob($data['business']);
            $dealerModel->setHexacode($data['hexacode']);
            $dealerModel->setSfdc($data['is_sfdc']);
            $dealerModel->save();
            $progressBar->advance();
        }
        $progressBar->finish();
        $output->writeln('Import finished...!');
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("cybage_storelocator:dealerimport");
        $this->setDescription("Import Dealer");
        $this->setDefinition([
            new InputArgument(self::FILE_PATH, InputArgument::OPTIONAL, "Name")
        ]);
        parent::configure();
    }
}
