<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cybage\AttributeClustering\Model\Product\Attribute\Backend;

class Sku extends \Magento\Catalog\Model\Product\Attribute\Backend\Sku
{
    const SKU_MAX_LENGTH = 255;

    /**
     * Validate SKU
     *
     * @param Product $object
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function validate($object)
    {
        $attrCode = $this->getAttribute()->getAttributeCode();
        $value = $object->getData($attrCode);
        if ($this->getAttribute()->getIsRequired() && strlen($value) === 0) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The "%1" attribute value is empty. Set the attribute and try again.', $attrCode)
            );
        }

        if ($this->string->strlen($object->getSku()) > self::SKU_MAX_LENGTH) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('SKU length should be %1 characters maximum.', self::SKU_MAX_LENGTH)
            );
        }
        return true;
    }
}
