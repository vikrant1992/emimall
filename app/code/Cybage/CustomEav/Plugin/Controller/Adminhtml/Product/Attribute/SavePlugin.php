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
namespace Cybage\CustomEav\Plugin\Controller\Adminhtml\Product\Attribute;

use Magento\Catalog\Controller\Adminhtml\Product\Attribute\Save;

/**
 * Class ControllerOrderIndexPlugin
 */
class SavePlugin
{   
    /**
     * @var \Magento\Framework\Message\ManagerInterface $messageManager
     */
    protected $_messageManager;
    
    /**
     * @var \Magento\Framework\App\RequestInterface $request
     */
    protected $_request;
    
    /**
     *
     * @var \Magento\Framework\Filesystem $fileSystem 
     */
    protected $_fileSystem;
    
    /**
     *
     * @var \Magento\MediaStorage\Model\File\UploaderFactory $fileUploader 
     */
    protected $_fileUploader;

    /**
     * 
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Filesystem $fileSystem
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $fileUploader
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Filesystem $fileSystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploader,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->_request = $request;
        $this->_fileSystem = $fileSystem;
        $this->_fileUploader = $fileUploader;
        $this->_messageManager = $messageManager;
        $this->_mediaDirectory = $fileSystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        
    }
    
    /**
     * @param Save $subject
     */
    public function beforeExecute(
        Save $subject
    ) {
        $inputFieldName = 'highlight_icon';
        $folderName = 'highlight_icon/';
        try{
            $file = $this->_request->getFiles($inputFieldName);
            $fileName = ($file && array_key_exists('name', $file)) ? $file['name'] : null;
            if ($file && $fileName) {
                $target = $this->_mediaDirectory->getAbsolutePath($folderName);
                
                $uploader = $this->_fileUploader->create(['fileId' => $inputFieldName]);
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png','svg']);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(true);
                $uploader->save($target);
                $this->_request->setPostValue('highlight_icon',$uploader->getUploadedFileName());
            }
        } catch (\Exception $e) {
            $this->_messageManager->addError($e->getMessage());
        }
    }
}