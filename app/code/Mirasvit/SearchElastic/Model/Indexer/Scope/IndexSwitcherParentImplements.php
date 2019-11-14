<?php

namespace Mirasvit\SearchElastic\Model\Indexer\Scope;

use Mirasvit\Core\Service\CompatibilityService;

if (CompatibilityService::is22() || CompatibilityService::is23()) {
	class IndexSwitcherParentMediator implements \Magento\CatalogSearch\Model\Indexer\IndexSwitcherInterface
	{
	    private $switcher;

	    public function __construct(IndexSwitcher $switcher)
	    {
	        $this->switcher = $switcher;
	    }

	    public function switchIndex(array $dimensions)
	    {
	        $this->switcher->switchIndex($dimensions);
	    }
	}
}