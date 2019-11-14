<?php

/**
 * BFL Cybage_Attributemapping
 *
 * @category   Cybage_Attributemapping Helper
 * @package    BFL Cybage_Attributemapping
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Attributemapping\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * Constructor
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Cybage\Attributemapping\Model\AttributesFactory $attributeFactory
    ) {
        parent::__construct($context);
        $this->attributeFactory = $attributeFactory;
    }

    /**
     * Get whitelabel data
     * @return type
     */
    public function getAttributes($productSku)
    {
        $faqData = $this->attributeFactory->create()
                ->getCollection()
                ->addFieldToFilter('sku', ['eq' => $productSku])
                ->getFirstItem()
                ->getData();
        return $faqData;
    }

}
