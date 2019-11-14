<?php

namespace Mirasvit\SearchElastic\Model\Indexer\Scope;

if (!class_exists('Magento\CatalogSearch\Model\Indexer\Scope\State')) {
    class StateMediatorParent
    {
        public function get()
        {
            return true;
        }
    }
}