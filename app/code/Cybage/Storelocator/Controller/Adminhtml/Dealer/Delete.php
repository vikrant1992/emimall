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

class Delete extends \Cybage\Storelocator\Controller\Adminhtml\Dealer
{

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('dealer_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Cybage\Storelocator\Model\Dealer::class);
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Dealer.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['dealer_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Dealer to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
