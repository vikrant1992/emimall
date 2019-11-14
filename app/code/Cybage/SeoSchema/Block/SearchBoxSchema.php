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

class SearchBoxSchema extends \Magento\Framework\View\Element\Template
{
    /**
     * ENABLE_SEARCH_BOX_SCHEMA
     */
    const ENABLE_SEARCH_BOX_SCHEMA = 'seo_config/search_box/enable_search_box_schema';

    /**
     * SD_SCHEMA_URL
     */
    const SD_SCHEMA_URL = "http://schema.org/";

    /**
     * SD_WEBSITE
     */
    const SD_WEBSITE = "WebSite";

    /**
     * SD_SEARCHACTION
     */
    const SD_SEARCHACTION = "SearchAction";

    /**
     * SD_REQUIRED_NAME
     */
    const SD_REQUIRED_NAME = "required name";

    /**
     * SD_SEARCH_TERM_STRING
     */
    const SD_SEARCH_TERM_STRING = "search_term_string";

    /**
     * SD_CATALOG_SEARCH
     */
    const SD_CATALOG_SEARCH = "catalogsearch/result/index";

    /**
     * @var \Cybage\SeoSchema\Helper
     */
    protected $_helper;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Cybage\SeoSchema\Helper\Data $helper
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Cybage\SeoSchema\Helper\Data $helper
    ) {
        $this->registry = $registry;
        $this->_helper = $helper;
        parent::__construct($context);
    }

    /**
     * Is enabled?
     *
     * @return bool
     */
    public function isSearchBoxSchemaEnabled()
    {
        return $this->_helper->getConfigValue(self::ENABLE_SEARCH_BOX_SCHEMA);
    }

    /**
     * Store base url
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->getUrl();
    }

    /**
     * Search target url
     *
     * @return string
     */
    public function getTargetUrl()
    {
        return $this->getUrl(
            self::SD_CATALOG_SEARCH,
            array(
                '_query' => array(
                    'q' => '{'.self::SD_SEARCH_TERM_STRING.'}'
                )
            )
        );
    }

    /**
     * get search Structured Data
     *
     * @return string
     */
    public function showSearchStructuredData()
    {
        $searchStructuredData = array(
            "@context" => self::SD_SCHEMA_URL,
            "@type"    => self::SD_WEBSITE,
            "url"    => $this->getBaseUrl()
        );

        $potentialAction = array(
            "@type" => self::SD_SEARCHACTION,
            "target" =>  urldecode($this->getTargetUrl()),
            "query-input" => self::SD_REQUIRED_NAME."=".self::SD_SEARCH_TERM_STRING
        );
        $searchStructuredData["potentialAction"] = $potentialAction;

        return $this->_helper->createStructuredData($searchStructuredData);
    }
}
