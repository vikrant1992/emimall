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
 * @package   mirasvit/module-navigation
 * @version   1.0.77
 * @copyright Copyright (C) 2019 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\LayeredNavigation\Plugin\Catalog\Model\ResourceModel\Eav\Attribute;

use Mirasvit\LayeredNavigation\Api\Data\AttributeConfigInterface;
use Mirasvit\LayeredNavigation\Model\AttributeConfig\OptionConfig;
use Mirasvit\LayeredNavigation\Repository\AttributeConfigRepository;

class SavePlugin
{
    private $attributeConfigRepository;


    public function __construct(
        AttributeConfigRepository $attributeConfigRepository
    ) {
        $this->attributeConfigRepository = $attributeConfigRepository;
    }

    /**
     * @param \Magento\Catalog\Model\ResourceModel\Eav\Attribute $subject
     * @param \Closure                                           $proceed
     *
     * @return mixed
     */
    public function aroundSave($subject, \Closure $proceed)
    {
        $attributeCode = $subject->getAttributeCode();

        if (!$attributeCode) {
            return $proceed();
        }

        $attrConfig = $this->attributeConfigRepository->getByAttributeCode($attributeCode);

        if (!$attrConfig) {
            $attrConfig = $this->attributeConfigRepository->create();
            $attrConfig->setAttributeId($subject->getAttributeId())
                ->setAttributeCode($attributeCode);
        }

        $attrConfigData = $subject->getData('attribute_config');

        if (isset($attrConfigData[AttributeConfigInterface::OPTIONS_CONFIG])) {
            $optionsConfig = [];
            foreach ($attrConfigData[AttributeConfigInterface::OPTIONS_CONFIG] as $optionConfigData) {
                $optionConfig = new OptionConfig();

                $optionConfig->setOptionId($optionConfigData[OptionConfig::OPTION_ID])
                    ->setLabel($optionConfigData[OptionConfig::LABEL])
                    ->setIsFullImageWidth(isset($optionConfigData[OptionConfig::IS_FULL_IMAGE_WIDTH]) ? true : false);

                try {
                    $imageData = \Zend_Json::decode($optionConfigData['image']['file']);

                    $optionConfig->setImagePath(isset($imageData[0]['file']) ? $imageData[0]['file'] : '');
                } catch (\Exception $e) {
                }

                $optionsConfig[] = $optionConfig;
            }

            $attrConfig->setOptionsConfig($optionsConfig);
        }

        if (isset($attrConfigData[AttributeConfigInterface::CATEGORY_VISIBILITY_MODE])) {
            $attrConfig->setCategoryVisibilityMode($attrConfigData[AttributeConfigInterface::CATEGORY_VISIBILITY_MODE]);
        }

        if (isset($attrConfigData[AttributeConfigInterface::CATEGORY_DISPLAY_MODE])) {
            $attrConfig->setCategoryDisplayMode($attrConfigData[AttributeConfigInterface::CATEGORY_DISPLAY_MODE]);
        }

        if (isset($attrConfigData[AttributeConfigInterface::CATEGORY_VISIBILITY_IDS])) {
            $attrConfig->setCategoryVisibilityIds($attrConfigData[AttributeConfigInterface::CATEGORY_VISIBILITY_IDS]);
        }

        $this->attributeConfigRepository->save($attrConfig);

        return $proceed();
    }
}
