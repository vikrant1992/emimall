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



namespace Mirasvit\Brand\Model\Image;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Image\Factory as ImageFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class ThumbnailFile
{
    /**
     * @var ImageFactory
     */
    private $imageProcessorFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var array
     */
    private $sizeByTypes = [
        'thumbnail'   => 75,
        'small_image' => 95,
    ];

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(
        ImageFactory $imageProcessorFactory,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager
    ) {
        $this->imageProcessorFactory = $imageProcessorFactory;
        $this->filesystem = $filesystem;
        $this->storeManager = $storeManager;
    }

    /**
     * @param string $imageType
     * @param string $fileName
     *
     * @return bool
     */
    public function hasImage($imageType, $fileName)
    {
        return $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)
            ->isExist($this->getImagePath($imageType, $fileName));
    }

    /**
     * @param $imageType
     * @param $fileName
     *
     * @throws LocalizedException
     */
    public function createImage($imageType, $fileName)
    {
        $path     = $this->getImagePath($imageType, $fileName);
        $mediaDir = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);

        $mediaDir->copyFile("brand/brand/{$fileName}", $path);

        $imageProcessor = $this->imageProcessorFactory->create($mediaDir->getAbsolutePath($path));
        $imageProcessor->keepAspectRatio(true);
        $imageProcessor->keepFrame(true);
        $imageProcessor->keepTransparency(true);
        $imageProcessor->backgroundColor([255, 255, 255]);
        $imageProcessor->constrainOnly(true);
        $imageProcessor->quality(80);
        $imageProcessor->resize($this->getImageSize($imageType));
        $imageProcessor->save();
    }

    /**
     * @param string $imageType
     * @param string $fileName
     *
     * @return string
     */
    public function getImageUrl($imageType, $fileName)
    {
        return $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA)
            . $this->getImagePath($imageType, $fileName);
    }

    /**
     * @param string $imageType
     *
     * @return string
     */
    public function getPlaceholderPath($imageType)
    {
        return "Magento_Catalog::images/product/placeholder/{$imageType}.jpg";
    }

    /**
     * @param string $imageType
     * @param string $fileName
     *
     * @return string
     */
    private function getImagePath($imageType, $fileName)
    {
        return "brand/{$imageType}/brand/{$fileName}";
    }

    /**
     * @param string $imageType
     *
     * @return mixed
     * @throws LocalizedException
     */
    private function getImageSize($imageType)
    {
        if (!isset($this->sizeByTypes[$imageType])) {
            throw new LocalizedException(__('Unknown image type %1', $imageType));
        }

        return $this->sizeByTypes[$imageType];
    }
}
