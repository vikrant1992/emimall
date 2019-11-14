<?php

namespace Mirasvit\SearchElastic\Model\Indexer\Scope;

use Mirasvit\Core\Service\CompatibilityService;

// @codingStandardsIgnoreStart
if (CompatibilityService::is22() || CompatibilityService::is23()) {
    require_once 'StateMediatorExtends.php';
} else {
    require_once 'StateMediatorSimple.php';
}
// @codingStandardsIgnoreEnd

class StateMediator extends StateMediatorParent
{
	const USE_TEMPORARY_INDEX = 'use_temporary_table';
    const USE_REGULAR_INDEX = 'use_main_table';
}
