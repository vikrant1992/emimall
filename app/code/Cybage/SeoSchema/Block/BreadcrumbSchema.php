<?php
/**
 * BFL Cybage_SeoSchema
 *
 * @category   Cybage_SeoSchema Block
 * @package    BFL Cybage_SeoSchema
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\SeoSchema\Block;

class BreadcrumbSchema extends \Magento\Framework\View\Element\Template
{
    /**
     * ENABLE_BREADCRUMB_SCHEMA
     */
    const ENABLE_BREADCRUMB_SCHEMA = 'seo_config/breadcrumb/enable_breadcrumb_schema';

    /**
     * SD_POSITION
     */
    const SD_POSITION = 1;

    /**
     * SD_HOME
     */
    const SD_HOME = "Home";

    /**
     * SD_BREADCRUMBLIST
     */
    const SD_BREADCRUMBLIST = "BreadcrumbList";

    /**
     * SD_SCHEMA_URL
     */
    const SD_SCHEMA_URL = "http://schema.org/";

    /**
     * SD_LISTITEM
     */
    const SD_LISTITEM = "ListItem";

    /**
     * @var \Cybage\SeoSchema\Helper
     */
    protected $_helper;

    /**
     * @var \Magento\Catalog\Helper\Data
     */
    protected $_catalogData;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlInterface;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Cybage\SeoSchema\Helper\Data $helper
     * @param \Magento\Catalog\Helper\Data $catalogData
     * @param \Magento\Framework\UrlInterface $urlInterface
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Cybage\SeoSchema\Helper\Data $helper,
        \Magento\Catalog\Helper\Data $catalogData,
        \Magento\Framework\UrlInterface $urlInterface
    ) {
        $this->registry = $registry;
        $this->_helper = $helper;
        $this->_catalogData = $catalogData;
        $this->_urlInterface = $urlInterface;
        parent::__construct($context);
    }

    /**
     * Is enabled?
     *
     * @return bool
     */
    public function isBreadcrumbSchemaEnabled()
    {
        return $this->_helper->getConfigValue(self::ENABLE_BREADCRUMB_SCHEMA);
    }

    /**
     * get breadcrumb structured data
     *
     * @return string
     */
    public function showBreadcrumbStructuredData()
    {
        $breadcrumbPath = $this->getBreadcrumbPath();
        if (is_array($breadcrumbPath) && !empty($breadcrumbPath)) {
            $breadcrumStructuredData = array(
                "@context" => self::SD_SCHEMA_URL,
                "@type" => self::SD_BREADCRUMBLIST
            );

            $itemListElement = array();
            $position = self::SD_POSITION;

            $listItem = array(
                "@type" => self::SD_LISTITEM,
                "position" => $position,
                "name" => self::SD_HOME,
                "item" => $this->getBaseUrl()
            );
            $itemListElement[] = $listItem;
            $position++;

            foreach ($breadcrumbPath as $data) {
                $listItem = array(
                    "@type" => self::SD_LISTITEM
                );

                $listItem['position'] = $position;
                $listItem['name'] = $data['label'];

                if (!empty($data['link'])) {
                    $link = $data['link'];
                } else {
                    $link = $this->getCurrentPageUrl();
                }
                $listItem['item'] = $link;

                $position++;
                $itemListElement[] = $listItem;
            }

            $breadcrumStructuredData["itemListElement"] = $itemListElement;

            return $this->_helper->createStructuredData($breadcrumStructuredData);
        }
    }

    /**
     * Get Breadcrumb Path
     *
     * @return array
     */
    public function getBreadcrumbPath()
    {
        $breadcrumbPath = $this->_catalogData->getBreadcrumbPath();
        return $breadcrumbPath;
    }

    /**
     * Get Base URL
     *
     * @return array
     */
    public function getBaseUrl()
    {
        $baseUrl = $this->_urlInterface->getBaseUrl();
        return $baseUrl;
    }

    /**
     * Get Current Page URL
     *
     * @return array
     */
    public function getCurrentPageUrl()
    {
        $currentUrl = $this->_urlInterface->getCurrentUrl();
        return $currentUrl;
    }
}
