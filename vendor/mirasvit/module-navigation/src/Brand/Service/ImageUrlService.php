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



namespace Mirasvit\Brand\Service;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Asset\Repository as AssetRepository;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Mirasvit\Brand\Api\Service\ImageUrlServiceInterface;
use Mirasvit\Brand\Model\Image\ThumbnailFile;

class ImageUrlService implements ImageUrlServiceInterface
{
    /**
     * @var AssetRepository
     */
    private $assertRepository;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var ThumbnailFile
     */
    private $thumbnailFile;

    public function __construct(
        AssetRepository $assertRepository,
        UrlInterface $urlBuilder,
        StoreManagerInterface $storeManager,
        ThumbnailFile $thumbnailFile
    ) {
        $this->assertRepository = $assertRepository;
        $this->urlBuilder       = $urlBuilder;
        $this->storeManager     = $storeManager;
        $this->thumbnailFile    = $thumbnailFile;
    }

    /**
     * @param string      $imageName
     * @param string|bool $imageType
     *
     * @return string
     */
    public function getImageUrl($imageName, $imageType = false)
    {
        if ($imageType) {
            $placeholderUrl = $this->assertRepository->getUrl($this->thumbnailFile->getPlaceholderPath($imageType));
            if (empty($imageName)) {
                return $placeholderUrl;
            }
            if (!$this->thumbnailFile->hasImage($imageType, $imageName)) {
                try {
                    $this->thumbnailFile->createImage($imageType, $imageName);
                } catch (\Exception $e) {
                    return $placeholderUrl;
                }
            }

            $image = $this->thumbnailFile->getImageUrl($imageType, $imageName);
        } else {
            /** @var Store $store */
            $store = $this->storeManager->getStore();
            $image = $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . "brand/brand/{$imageName}";
        }

        return $image;
    }
}
