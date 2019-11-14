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
use Mirasvit\Sorting\Api\Data\RankingFactorInterface;
use Mirasvit\Sorting\Controller\Adminhtml\CriterionAbstract;
use Mirasvit\Sorting\Data\ConditionCluster;

class Save extends CriterionAbstract
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = $this->getRequest()->getParam(RankingFactorInterface::ID);

        $model = $this->initModel();

        $data = $this->getRequest()->getParams();

        $data = $this->filter($data, $model);

        if ($data) {
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This criteria no longer exists.'));

                return $resultRedirect->setPath('*/*/');
            }

            $model->setName($data[CriterionInterface::NAME])
                ->setIsActive($data[CriterionInterface::IS_ACTIVE])
                ->setIsDefault($data[CriterionInterface::IS_DEFAULT])
                ->setIsSearchDefault($data[CriterionInterface::IS_SEARCH_DEFAULT])
                ->setCode($data[CriterionInterface::CODE])
                ->setPosition($data[CriterionInterface::POSITION])
                ->setConditionCluster($data[CriterionInterface::CONDITIONS]);

            try {
                $this->criterionRepository->save($model);

                $this->messageManager->addSuccessMessage(__('You saved the criteria.'));

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', [CriterionInterface::ID => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', [CriterionInterface::ID => $model->getId()]);
            }
        } else {
            $resultRedirect->setPath('*/*/');
            $this->messageManager->addErrorMessage('No data to save.');

            return $resultRedirect;
        }
    }

    /**
     * @param array              $data
     * @param CriterionInterface $model
     *
     * @return array
     */
    private function filter(array $data, CriterionInterface $model)
    {
        if (!$data[CriterionInterface::POSITION]) {
            $data[CriterionInterface::POSITION] = 1;
        }

        if (!isset($data[CriterionInterface::CONDITIONS])) {
            $data[CriterionInterface::CONDITIONS] = [];
        }

        $conditionCluster = new ConditionCluster();
        $conditionCluster->loadArray($data[CriterionInterface::CONDITIONS]);

        $data[CriterionInterface::CONDITIONS] = $conditionCluster;

        return $data;
    }
}
