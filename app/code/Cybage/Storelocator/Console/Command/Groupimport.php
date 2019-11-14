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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Filesystem\DirectoryList;
use Symfony\Component\Console\Helper\ProgressBar;

class Groupimport extends Command
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
     * @param \Cybage\Storelocator\Model\DealergroupFactory $groupFactory
     * @param DirectoryList $directoryList
     */
    public function __construct(
        \Magento\Framework\File\Csv $csvProcessor,
        \Cybage\Storelocator\Model\DealerFactory $dealerFactory,
        \Cybage\Storelocator\Model\DealergroupFactory $groupFactory,
        DirectoryList $directoryList
    ) {
        $this->csvProcessor = $csvProcessor;
        $this->dealerFactory = $dealerFactory;
        $this->groupFactory = $groupFactory;
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
        $this->validateDealerGroupImportFile($path, $output);
    }

    /**
     * Validate groups csv
     * @param type $path
     * @return type
     */
    public function validateDealerGroupImportFile($path, $output)
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
            $this->processGroupUpload($importFile, $output);
            echo __('Groups impoted successfully.');
        }
    }

    /**
     * Import Group
     * @param type $importFile
     */
    public function processGroupUpload($importFile, $output)
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
            $groupModel = $this->groupFactory->create()->load($data['group_id'], 'group_id');
            $groupModel->setGroupId($data['group_id']);
            $groupModel->setStoreName($data['store_name']);
            $groupModel->save();
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
        $this->setName("cybage_storelocator:groupimport");
        $this->setDescription("Import Groups");
        $this->setDefinition([
            new InputArgument(self::FILE_PATH, InputArgument::OPTIONAL, "Group import CSV file path")
        ]);
        parent::configure();
    }
}
