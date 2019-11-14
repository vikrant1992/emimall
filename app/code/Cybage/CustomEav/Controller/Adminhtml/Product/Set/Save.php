<?php

/**
 * BFL Cybage_CustomEav
 *
 * @category   Cybage_CustomEav
 * @package    BFL Cybage_CustomEav
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\CustomEav\Controller\Adminhtml\Product\Set;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\App\ObjectManager;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Save extends \Magento\Catalog\Controller\Adminhtml\Product\Set implements HttpPostActionInterface
{
    /*
     * @var \Magento\Eav\Model\Entity\Attribute\SetFactory
     */
    private $attributeSetFactory;
    
    /**
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Eav\Model\Entity\Attribute\SetFactory $attributeSetFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Eav\Model\Entity\Attribute\SetFactory $attributeSetFactory = null
    ) {
        parent::__construct($context, $coreRegistry);
        $this->attributeSetFactory =  $attributeSetFactory ?: ObjectManager::getInstance()
            ->get(\Magento\Eav\Model\Entity\Attribute\SetFactory::class);
    }

    /**
     * Retrieve catalog product entity type id
     *
     * @return int
     */
    protected function _getEntityTypeId()
    {
        if ($this->_coreRegistry->registry('entityType') === null) {
            $this->_setTypeId();
        }
        return $this->_coreRegistry->registry('entityType');
    }

    /**
     * Save attribute set action
     *
     * [POST] Create attribute set from another set and redirect to edit page
     * [AJAX] Save attribute set data
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        $attributeSetId = $data['attribute_set_id'];
        /* @var $model \Magento\Eav\Model\Entity\Attribute\Set */
        $model = $this->attributeSetFactory->create();

        try {
            if ($attributeSetId) {
                $model->load($attributeSetId);
            }
            if (!$model->getId()) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('This attribute set no longer exists.')
                );
            }
            $data['attribute_set_keyhighlights'] = implode(",", $data['attribute_set_keyhighlights']);
            $model->setData($data);
            $model->save();
            $this->messageManager->addSuccessMessage(__('You saved the attribute set Mapping.'));
        } catch (\Magento\Framework\Exception\AlreadyExistsException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the attribute set.'));
        }
        return $resultRedirect->setPath('*/*/');
    }
}
