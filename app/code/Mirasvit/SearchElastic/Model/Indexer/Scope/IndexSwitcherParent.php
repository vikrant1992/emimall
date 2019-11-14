<?php

namespace Mirasvit\SearchElastic\Model\Indexer\Scope;

use Mirasvit\Core\Service\CompatibilityService;

// @codingStandardsIgnoreStart
if (CompatibilityService::is22() || CompatibilityService::is23()) {
    require_once 'IndexSwitcherParentImplements.php';
} else {
    require_once 'IndexSwitcherParentExtends.php';
}
// @codingStandardsIgnoreStart

class IndexSwitcherParent extends IndexSwitcherParentMediator
{

}
