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



namespace Mirasvit\Sorting\Ui\RankingFactor\Form\Modifier;

use Magento\Catalog\Model\Product\AttributeSet\Options as AttributeSetOptions;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Mirasvit\Sorting\Api\Data\RankingFactorInterface;
use Mirasvit\Sorting\Factor\AttributeSetFactor;

class AttributeSetModifier implements ModifierInterface
{
    use MappingTrait;

    private $options;

    public function __construct(
        AttributeSetOptions $options
    ) {
        $this->options = $options;
    }

    public function modifyData(array $data)
    {
        $mapping = isset($data[RankingFactorInterface::CONFIG][AttributeSetFactor::MAPPING])
            ? $data[RankingFactorInterface::CONFIG][AttributeSetFactor::MAPPING]
            : [];

        $mapping = $this->sync($this->options->toOptionArray(), $mapping);

        $data[RankingFactorInterface::CONFIG][AttributeSetFactor::MAPPING] = $mapping;

        return $data;
    }

    public function modifyMeta(array $meta)
    {
        return $meta;
    }
}
