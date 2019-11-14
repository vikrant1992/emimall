<?php

namespace Mirasvit\SearchElastic\Plugin\Magento\CatalogSearch\Model\Indexer\Scope;

use Magento\CatalogSearch\Model\Indexer\Scope\State;

class StatePlugin
{
    public static $storedState = State::USE_REGULAR_INDEX;

    /**
     * Set the state to use temporary Index
     *
     * @return void
     */
    public function afterUseTemporaryIndex($subject, $response)
    {
        self::$storedState = State::USE_TEMPORARY_INDEX;
    }

    /**
     * Set the state to use regular Index
     *
     * @return void
     */
    public function afterUseRegularIndex($subject, $response)
    {
        self::$storedState = State::USE_REGULAR_INDEX;
    }

    /**
     * Get state.
     *
     * @return string
     */
    public function afterGetState($subject, $response)
    {
        return self::$storedState;
    }
}
