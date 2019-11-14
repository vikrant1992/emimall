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

namespace Cybage\Storelocator\Controller\Adminhtml\Dealer;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    /**
     *
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;
    
    /**
     *
     * @var \Cybage\Storelocator\Model\ImageUploaderPool
     */
    protected $imageUploaderPool;

    /**
     * Constructor
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Cybage\Storelocator\Model\ImageUploaderPool $imageUploaderPool
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->imageUploaderPool = $imageUploaderPool;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $id = $this->getRequest()->getParam('dealer_id');

            $model = $this->_objectManager->create(\Cybage\Storelocator\Model\Dealer::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Dealer no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            
            $dealerLogoImage = $this->getUploader('image')->uploadFileAndGetName('dealer_logo', $data);
            $data['dealer_logo'] = $dealerLogoImage;
            
            if (isset($data['subcategories'])) {
                $data['subcategories'] = implode(',', $data['subcategories']);
            }
            $group = explode('-', $data['group_id']);
            if (isset($group[1])) {
                $data['group_id'] = trim($group[1]);
            } else {
                $data['group_id'] = '';
            }
            $city = explode('-', $data['city_id']);
            if (isset($city[1])) {
                $data['city_id'] = trim($city[1]);
            } else {
                $data['city_id'] = '';
            }
            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Dealer.'));
                $this->dataPersistor->clear('cybage_storelocator_dealer');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['dealer_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Dealer.'));
            }

            $this->dataPersistor->set('cybage_storelocator_dealer', $data);
            return $resultRedirect->setPath('*/*/edit', ['dealer_id' => $this->getRequest()->getParam('dealer_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
    
    /**
     * @param $type
     * @return Uploader
     * @throws \Exception
     */
    protected function getUploader($type)
    {
        return $this->imageUploaderPool->getUploader($type);
    }
}
