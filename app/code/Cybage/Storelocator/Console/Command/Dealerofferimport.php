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

class Dealerofferimport extends Command
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
     * @param \Cybage\Storelocator\Model\OfferFactory $offerFactory
     * @param DirectoryList $directoryList
     * @param \Magento\Framework\App\ResourceConnection $resourceconnection
     */
    public function __construct(
        \Magento\Framework\File\Csv $csvProcessor,
        \Cybage\Storelocator\Model\OfferFactory $offerFactory,
        DirectoryList $directoryList,
        \Magento\Framework\App\ResourceConnection $resourceconnection
    ) {
        $this->csvProcessor = $csvProcessor;
        $this->offerFactory = $offerFactory;
        $this->directoryList = $directoryList;
        $this->connection = $resourceconnection;
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
            echo __('Dealer offers impoted successfully.');
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
            $offerModel = $this->offerFactory->create();
            $offerModel->setDealerid($dataRow[0]);
            $offerModel->setDealerofferid($dataRow[1]);
            $offerModel->setOfferText($dataRow[2]);
            $offerModel->save();
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
        $this->setName("cybage_storelocator:offerimport");
        $this->setDescription("Import Dealer Offers");
        $this->setDefinition([
            new InputArgument(self::FILE_PATH, InputArgument::OPTIONAL, "Name")
        ]);
        parent::configure();
    }
}
