<?php

namespace Mirasvit\SearchElastic\Console\Command;

use Magento\CatalogSearch\Model\Indexer\Fulltext;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\ObjectManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\State;
use Mirasvit\SearchElastic\Model\Engine;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * @SuppressWarnings(PHPMD)
 */
class TestCommand extends AbstractCommand
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory,
        ObjectManagerInterface $objectManager,
        State $appState
    ) {
        $this->collectionFactory = $collectionFactory;

        parent::__construct($objectManager, $appState);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('mirasvit:search-elastic:test')
            ->setDescription('For test purpose');

        $this->addOption('reset');

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->appState->setAreaCode('frontend');
        } catch (\Exception $e) {
        }

        $collection = $this->collectionFactory->create()
            ->addFieldToFilter('visibility', [3, 4])
            ->addFieldToFilter('status', 1);

        $collection->getSelect()->orderRand();

        if ($input->getOption('reset')) {
            $this->engine->reset();
        }

        /** @var \Magento\Framework\Indexer\IndexerRegistry $indexRegistry */
        $indexRegistry = $this->objectManager->create('Magento\Framework\Indexer\IndexerRegistry');

        $indexer = $indexRegistry->get(Fulltext::INDEXER_ID);

        try {
            $bar = new ProgressBar($output, $collection->getSize());
            $bar->start();
            foreach ($collection as $product) {
                $output->writeln('<info>'. $product->getId() .'</info>');
                $indexer->reindexRow($product->getId());
                $bar->advance();
            }
            $bar->finish();
        } catch (\Magento\Eav\Model\Entity\Attribute\Exception $e) {
        } catch (NoSuchEntityException $e) {
        } catch (\Exception $e) {
            $output->writeln("<error>{$e->getMessage()}</error>");
        }
    }
}
