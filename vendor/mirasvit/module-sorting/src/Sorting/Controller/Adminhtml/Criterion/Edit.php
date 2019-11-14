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



namespace Mirasvit\Sorting\Controller\Adminhtml\Criterion;

use Magento\Framework\Controller\ResultFactory;
use Mirasvit\Sorting\Api\Data\CriterionInterface;
use Mirasvit\Sorting\Controller\Adminhtml\CriterionAbstract;

class Edit extends CriterionAbstract
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $model = $this->initModel();
        $id    = $this->getRequest()->getParam(CriterionInterface::ID);

        if ($id && !$model) {
            $this->messageManager->addErrorMessage(__('This criteria no longer exists.'));
            $resultRedirect = $this->resultRedirectFactory->create();

            return $resultRedirect->setPath('*/*/');
        }

        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $this->initPage($resultPage)
            ->getConfig()->getTitle()->prepend(
                $model->getId() ? __('Criteria "%1"', $model->getName()) : __('New Criteria')
            );

        return $resultPage;
    }
}
