<?php

namespace Mirasvit\SearchElastic\Model\Indexer\Scope;

if (class_exists('Magento\CatalogSearch\Model\Indexer\Scope\State')) {
    class StateMediatorParent
    {
        private $state;

        public function __construct(\Magento\CatalogSearch\Model\Indexer\Scope\State $state)
        {
            $this->state = $state;
        }

        public function get()
        {
            return $this->state;
        }
    }
}
