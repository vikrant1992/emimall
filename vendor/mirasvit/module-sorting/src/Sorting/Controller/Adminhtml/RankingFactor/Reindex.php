<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at https://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   mirasvit/module-sorting
 * @version   1.0.25
 * @copyright Copyright (C) 2019 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\Sorting\Controller\Adminhtml\RankingFactor;

use Magento\Framework\App\ObjectManager;
use Mirasvit\Sorting\Api\Data\RankingFactorInterface;
use Mirasvit\Sorting\Controller\Adminhtml\RankingFactorAbstract;
use Mirasvit\Sorting\Model\Indexer;

class Reindex extends RankingFactorAbstract
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $model = $this->initModel();

        if (!$model->getId()) {
            $this->messageManager->addErrorMessage(__('This factor no longer exists.'));

            return $resultRedirect->setPath('*/*/');
        }

        try {
            $objectManager = ObjectManager::getInstance();

            /** @var \Mirasvit\Sorting\Model\Indexer $indexer */
            $indexer = $objectManager->create(Indexer::class);
            $indexer->executeFull([$model->getId()]);

            $this->messageManager->addSuccessMessage(__('Reindex was completed.'));

            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', [RankingFactorInterface::ID => $model->getId()]);
            }

            return $resultRedirect->setPath('*/*/');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());

            return $resultRedirect->setPath('*/*/edit', [RankingFactorInterface::ID => $model->getId()]);
        }
    }
}
