<?php

namespace Mirasvit\SearchElastic\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\Search\Request\Dimension;
use Magento\Framework\Locale\Resolver as LocaleResolver;
use Magento\Store\Model\ScopeInterface;

class Config
{
    /**
     * @var LocaleResolver
     */
    private $localeResolver;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var Filesystem
     */
    private $filesystem;

    const DOCUMENT_TYPE = 'doc';

    public function __construct(
        LocaleResolver $localeResolver,
        ScopeConfigInterface $scopeConfig,
        Filesystem $filesystem
    ) {
        $this->localeResolver = $localeResolver;
        $this->scopeConfig = $scopeConfig;
        $this->filesystem = $filesystem;
    }

    /**
     * @return string
     */
    public function getEngine()
    {
        return $this->scopeConfig->getValue('search/engine/engine');
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->scopeConfig->getValue('search/engine/elastic_host');
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return intval($this->scopeConfig->getValue('search/engine/elastic_port'));
    }

    /**
     * @return string
     */
    public function getIndexPrefix()
    {
        return strtolower($this->scopeConfig->getValue('search/engine/elastic_prefix'));
    }

    /**
     * @param string $indexName
     * @return string
     */
    public function getIndexName($indexName)
    {

        return $this->getIndexPrefix() . '_' . $indexName;
    }

    /**
     * @return bool
     */
    public function isShowOutOfStock()
    {
        return $this->scopeConfig->isSetFlag('cataloginventory/options/show_out_of_stock');
    }

    /**
     * @return bool
     */
    public function isFastMode()
    {
        return $this->scopeConfig->isSetFlag('searchautocomplete/general/fast_mode');
    }

    /**
     * @param Dimension $dimension
     * @return string
     */
    public function getStemmer(Dimension $dimension)
    {
        $supported = [
            'ar' => 'arabic',
            'hy' => 'armenian',
            'bn' => 'bengali',
            'br' => 'brazilian',
            'bg' => 'bulgarian',
            'ca' => 'catalan',
            'cs' => 'czech',
            'da' => 'danish',
            'nl' => 'dutch',
            'fi' => 'finnish',
            'el' => 'greek',
            'hu' => 'hungarian',
            'it' => 'italian',
            'lv' => 'latvian',
            'lt' => 'lithuanian',
            'nb' => 'norwegian',
            'nn' => 'norwegian',
            'pt' => 'portuguese',
            'es' => 'spanish',
            'sv' => 'swedish',
            'en' => 'english',
            'de' => 'german',
            'fr' => 'french',
            'ru' => 'russian',
        ];

        $this->localeResolver->emulate($dimension->getValue());
        $locale = strtolower(explode('_', $this->localeResolver->getLocale())[0]);

        return isset($supported[$locale]) ? $supported[$locale] : 'english';
    }

    /**
     * @return int
     */
    public function getResultsLimit()
    {
        $limit = (int)$this->scopeConfig->getValue('search/advanced/results_limit', ScopeInterface::SCOPE_STORE);
        if (!$limit || filter_input(INPUT_GET, 'q') == null) {
            $limit = 100000;
        }

        return $limit;
    }
}
