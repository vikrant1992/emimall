<?php
namespace Mirasvit\SearchElastic\Controller\Adminhtml\Command;

use Mirasvit\SearchElastic\Controller\Adminhtml\Command;
use Magento\Framework\Indexer\ScopeResolver\IndexScopeResolver;
use Mirasvit\Search\Api\Repository\IndexRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;

use Mirasvit\SearchElastic\Model\Engine;
use Magento\Backend\App\Action\Context;

class ResetStoreIndexes extends Command
{
    public function __construct(
        IndexScopeResolver $resolver,
        IndexRepositoryInterface $indexRepository,
        StoreManagerInterface $storeManager,
        Engine $engine,
        Context $context
    ){
        $this->resolver         = $resolver;
        $this->indexRepository  = $indexRepository;
        $this->storeManager     = $storeManager;
        $this->engine           = $engine;
        $this->context          = $context;

        parent::__construct($context, $engine);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $success = true;
        $note = '';
        $message = '';

        $indexes = []; 

        foreach ($this->indexRepository->getList() as $index) {
            foreach ($this->storeManager->getStores() as $store) {
                $dimension = [
                    new \Magento\Framework\DataObject(['name'  => 'scope', 'value' => $store->getId(),])
                ];

                $indexes[] = $this->resolver->resolve($index->getIdentifier(), $dimension);
            }
        }

        if (class_exists('Elasticsearch\ClientBuilder')){
            try {
                $this->engine->resetStoreIndexes($indexes);
                $message .= __('Done.');
            } catch (\Exception $e) {
                $message = $e->getMessage();
                $success = false;
            }
        } else {
            $success = false;
            $message = __('Elasticsearch library is not installed, please run the following :');
            $note = __('composer require elasticsearch/elasticsearch:~5.1');
        }

        $jsonData = json_encode([
            'message' => nl2br($message),
            'note'    => $note,
            'success' => $success,
        ]);

        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody($jsonData);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->context->getAuthorization()->isAllowed('Mirasvit_SearchElastic::command_reset');
    }
}
