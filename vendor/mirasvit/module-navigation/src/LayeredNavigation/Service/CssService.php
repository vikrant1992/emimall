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
 * @package   mirasvit/module-navigation
 * @version   1.0.77
 * @copyright Copyright (C) 2019 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\LayeredNavigation\Service;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Message\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Variable\Model\VariableFactory;
use Mirasvit\LayeredNavigation\Api\Data\CssVariableInterface;

class CssService
{
    const PUB                 = 'pub';
    const CSS_FIRST_PART_NAME = 'settings_';
    const CSS_PATH            = '/media/mirasvit_ln/';

    public function __construct(
        DirectoryList $directoryList,
        StoreManagerInterface $storeManager,
        ManagerInterface $messageManager,
        CssCreatorService $cssCreatorService,
        VariableFactory $variableFactory
    ) {
        $this->directoryList     = $directoryList;
        $this->storeManager      = $storeManager;
        $this->messageManager    = $messageManager;
        $this->cssCreatorService = $cssCreatorService;
        $this->variableFactory   = $variableFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function generateCss($websiteId, $storeId)
    {
        if (!$websiteId && !$storeId) {
            $websites = $this->storeManager->getWebsites(false, false);
            foreach ($websites as $id => $value) {
                $this->generateWebsiteCss($id);
            }
        } else {
            if ($storeId) {
                $this->generateStoreCss($storeId);
            } else {
                $this->generateWebsiteCss($websiteId);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function generateWebsiteCss($websiteId)
    {
        $website = $this->storeManager->getWebsite($websiteId);
        foreach ($website->getStoreIds() as $storeId) {
            $this->generateStoreCss($storeId);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function generateStoreCss($storeId)
    {
        $store = $this->storeManager->getStore($storeId);
        if (!$store->isActive()) {
            return false;
        }

        $css = $this->getCss($storeId);
        if (!$css) {
            return false;
        }

        $variable = $this->loadVariable($storeId);
        if (!$variable || !$variable->getData()) {
            $this->createVariable();
            $variable = $this->loadVariable($storeId);
        }

        $variableValue = uniqid();
        $variable->setPlainValue($variableValue)->setStorePlainValue($variableValue)->save();

        $storeCode       = $store->getCode();
        $fullCssDirPath  = $this->getFullCssDirPath($storeCode);
        $fullCssFilePath = $this->getFullCssFilePath($storeCode, $storeId);

        try {
            if (!file_exists($fullCssDirPath)) {
                if (preg_match('/\/$/', $fullCssDirPath)) {
                    $fullCssDirPath = substr($fullCssDirPath, 0, -1);
                }

                $dirName = explode('/', $fullCssDirPath);
                $dirName = $dirName[count($dirName) - 1];

                $parentDir = str_replace('/' . $dirName, '', $fullCssDirPath);
                if (!is_dir($parentDir) || !is_writable($parentDir) || !mkdir($fullCssDirPath, 0777)) {
                    throw new \Exception(
                        "Directory \"" . $parentDir . "\" doesn't have write permissions or doesn't exist."
                    );
                }
            }
            if (!is_writable($fullCssDirPath)) {
                throw new \Exception("Directory \"" . $fullCssDirPath . "\" doesn't have write permissions.");
            }
            foreach (glob($fullCssDirPath . "*" . $storeCode . "*") as $filename) {
                unlink($filename);
            }
            $file = fopen($fullCssFilePath, "w+");
            flock($file, LOCK_EX);
            fwrite($file, $css);
            flock($file, LOCK_UN);
            fclose($file);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(
                __('Failed genareation CSS file: ' . $fullCssFilePath . ' in '
                    . $this->getFullCssDirPath($storeCode)
                    . '<br/>Message: ' . $e->getMessage())
            );
        }
    }

    /**
     * @return void
     */
    private function createVariable()
    {
        $variable = $this->variableFactory->create();
        $data     = [
            'code'        => CssVariableInterface::CSS_VARIABLE,
            'name'        => CssVariableInterface::CSS_VARIABLE,
            'html_value'  => '',
            'plain_value' => '',
        ];

        $variable->setData($data);
        $variable->save();
    }

    /**
     * @param $storeId
     *
     * @return \Magento\Variable\Model\Variable
     */
    private function loadVariable($storeId)
    {
        return $this->variableFactory->create()
            ->setStoreId($storeId)->loadByCode(CssVariableInterface::CSS_VARIABLE);
    }

    /**
     * {@inheritdoc}
     */
    public function getCssPath($storeCode = false, $storeId = false, $front = false)
    {
        if (!$storeCode) {
            $storeCode = $this->storeManager->getStoreCode();
        }

        if (!$storeId) {
            $storeCode = $this->storeManager->getStore()->getId();
        }

        $variable = $this->variableFactory->create()
            ->setStoreId($storeId)->loadByCode(CssVariableInterface::CSS_VARIABLE);

        $front = false;

        return $this->getCssDir($front)
            . self::CSS_FIRST_PART_NAME
            . $storeCode
            . $variable->getPlainValue()
            . '.css';
    }

    /**
     * @return string
     */
    private function getFullCssDirPath()
    {
        return $this->directoryList->getRoot() . '/' . $this->getCssDir();
    }

    /**
     * @return string
     */
    private function getFullCssFilePath($storeCode, $storeId)
    {
        return $this->directoryList->getRoot() . '/' . $this->getCssPath($storeCode, $storeId);
    }

    /**
     * @return string
     */
    private function getCssDir($front = false)
    {
        $pub = ($front) ? $this->getFrontPubPath() : self::PUB;

        return $pub . self::CSS_PATH;
    }

    /**
     * @return string
     */
    private function getFrontPubPath()
    {
        $pub = '';
        if ($this->directoryList->getUrlPath(self::PUB) == self::PUB) {
            $pub = '/' . self::PUB;
        }

        return $pub;
    }

    /**
     * @return string
     */
    private function getCss($storeId)
    {
        return $this->cssCreatorService->getCssContent($storeId);
    }
}