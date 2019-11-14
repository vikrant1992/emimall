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
 * @package   mirasvit/module-sorting
 * @version   1.0.25
 * @copyright Copyright (C) 2019 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\Sorting\Api\Data;

interface IndexInterface
{
    const TABLE_NAME = 'mst_sorting_index';

    CONST MIN = -100;
    CONST MAX = 100;

    const PRODUCT_ID = 'product_id';
    const FACTOR_ID  = 'factor_id';
    const VALUE      = 'value';
}