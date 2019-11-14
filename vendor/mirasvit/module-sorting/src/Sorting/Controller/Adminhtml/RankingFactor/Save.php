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

use Mirasvit\Sorting\Api\Data\RankingFactorInterface;
use Mirasvit\Sorting\Controller\Adminhtml\RankingFactorAbstract;

class Save extends RankingFactorAbstract
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
                $this->messageManager->addErrorMessage(__('This factor no longer exists.'));

                return $resultRedirect->setPath('*/*/');
            }

            $model->setName($data[RankingFactorInterface::NAME])
                ->setIsActive($data[RankingFactorInterface::IS_ACTIVE])
                ->setType($data[RankingFactorInterface::TYPE])
                ->setIsGlobal($data[RankingFactorInterface::IS_GLOBAL])
                ->setWeight($data[RankingFactorInterface::WEIGHT])
                ->setConfig($data[RankingFactorInterface::CONFIG]);

            try {
                $this->rankingFactorRepository->save($model);

                $this->messageManager->addSuccessMessage(__('You saved the factor.'));

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', [RankingFactorInterface::ID => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', [RankingFactorInterface::ID => $model->getId()]);
            }
        } else {
            $resultRedirect->setPath('*/*/');
            $this->messageManager->addErrorMessage('No data to save.');

            return $resultRedirect;
        }
    }

    /**
     * @param array                  $data
     * @param RankingFactorInterface $rankingFactor
     *
     * @return array
     */
    private function filter(array $data, RankingFactorInterface $rankingFactor)
    {
        if (!isset($data[RankingFactorInterface::CONFIG])) {
            $data[RankingFactorInterface::CONFIG] = [];
        }

        if (isset($data['rule'])) {
            $data[RankingFactorInterface::CONFIG]['rule'] = $data['rule'];
        }

        if (!isset($data[RankingFactorInterface::WEIGHT])) {
            $data[RankingFactorInterface::WEIGHT] = 0;
        }

        return $data;
    }
}
