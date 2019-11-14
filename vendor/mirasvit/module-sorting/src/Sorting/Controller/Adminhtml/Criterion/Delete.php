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

use Mirasvit\Sorting\Api\Data\CriterionInterface;
use Mirasvit\Sorting\Controller\Adminhtml\CriterionAbstract;

class Delete extends CriterionAbstract
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam(CriterionInterface::ID);

        if ($id) {
            try {
                $model = $this->criterionRepository->get($id);
                $this->criterionRepository->delete($model);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }

            $this->messageManager->addSuccessMessage(
                __('Criteria was removed')
            );
        } else {
            $this->messageManager->addErrorMessage(__('Please select criteria'));
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}