<?php

/**
 * BFL Attributemapping
 *
 * @category   Attributemapping Module
 * @package    BFL Attributemapping
 * @copyright  2019 All rights reserved.
 * @license    Proprietary
 * @author     BFL (bajaj finserv limited)
 */

namespace Cybage\Attributemapping\Model\Data;

use Cybage\Attributemapping\Api\Data\AttributesInterface;

class Attributes extends \Magento\Framework\Api\AbstractExtensibleObject implements AttributesInterface {

    /**
     * Get attributes_id
     * @return string|null
     */
    public function getAttributesId() {
        return $this->_get(self::ATTRIBUTES_ID);
    }

    /**
     * Set attributes_id
     * @param string $attributesId
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setAttributesId($attributesId) {
        return $this->setData(self::ATTRIBUTES_ID, $attributesId);
    }

    /**
     * Get model_code
     * @return string|null
     */
    public function getModelCode() {
        return $this->_get(self::MODEL_CODE);
    }

    /**
     * Set model_code
     * @param string $modelCode
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setModelCode($modelCode) {
        return $this->setData(self::MODEL_CODE, $modelCode);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Cybage\Attributemapping\Api\Data\AttributesExtensionInterface|null
     */
    public function getExtensionAttributes() {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Cybage\Attributemapping\Api\Data\AttributesExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
    \Cybage\Attributemapping\Api\Data\AttributesExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get model_name
     * @return string|null
     */
    public function getModelName() {
        return $this->_get(self::MODEL_NAME);
    }

    /**
     * Set model_name
     * @param string $modelName
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setModelName($modelName) {
        return $this->setData(self::MODEL_NAME, $modelName);
    }

    /**
     * Get sku
     * @return string|null
     */
    public function getSku() {
        return $this->_get(self::SKU);
    }

    /**
     * Set sku
     * @param string $sku
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setSku($sku) {
        return $this->setData(self::SKU, $sku);
    }

    /**
     * Get short_description
     * @return string|null
     */
    public function getShortDescription() {
        return $this->_get(self::SHORT_DESCRIPTION);
    }

    /**
     * Set short_description
     * @param string $shortDescription
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setShortDescription($shortDescription) {
        return $this->setData(self::SHORT_DESCRIPTION, $shortDescription);
    }

    /**
     * Get short_descriptor
     * @return string|null
     */
    public function getShortDescriptor() {
        return $this->_get(self::SHORT_DESCRIPTOR);
    }

    /**
     * Set short_descriptor
     * @param string $shortDescriptor
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setShortDescriptor($shortDescriptor) {
        return $this->setData(self::SHORT_DESCRIPTOR, $shortDescriptor);
    }

    /**
     * Get footer_title
     * @return string|null
     */
    public function getFooterTitle() {
        return $this->_get(self::FOOTER_TITLE);
    }

    /**
     * Set footer_title
     * @param string $footerTitle
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setFooterTitle($footerTitle) {
        return $this->setData(self::FOOTER_TITLE, $footerTitle);
    }

    /**
     * Get footer_content
     * @return string|null
     */
    public function getFooterContent() {
        return $this->_get(self::FOOTER_CONTENT);
    }

    /**
     * Set footer_content
     * @param string $footerContent
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setFooterContent($footerContent) {
        return $this->setData(self::FOOTER_CONTENT, $footerContent);
    }

    /**
     * Get question1
     * @return string|null
     */
    public function getQuestion1() {
        return $this->_get(self::QUESTION1);
    }

    /**
     * Set question1
     * @param string $question1
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setQuestion1($question1) {
        return $this->setData(self::QUESTION1, $question1);
    }

    /**
     * Get answer1
     * @return string|null
     */
    public function getAnswer1() {
        return $this->_get(self::ANSWER1);
    }

    /**
     * Set answer1
     * @param string $answer1
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setAnswer1($answer1) {
        return $this->setData(self::ANSWER1, $answer1);
    }

    /**
     * Get question2
     * @return string|null
     */
    public function getQuestion2() {
        return $this->_get(self::QUESTION2);
    }

    /**
     * Set question2
     * @param string $question2
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setQuestion2($question2) {
        return $this->setData(self::QUESTION2, $question2);
    }

    /**
     * Get answer2
     * @return string|null
     */
    public function getAnswer2() {
        return $this->_get(self::ANSWER2);
    }

    /**
     * Set answer2
     * @param string $answer2
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setAnswer2($answer2) {
        return $this->setData(self::ANSWER2, $answer2);
    }

    /**
     * Get question3
     * @return string|null
     */
    public function getQuestion3() {
        return $this->_get(self::QUESTION3);
    }

    /**
     * Set question3
     * @param string $question3
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setQuestion3($question3) {
        return $this->setData(self::QUESTION3, $question3);
    }

    /**
     * Get answer3
     * @return string|null
     */
    public function getAnswer3() {
        return $this->_get(self::ANSWER3);
    }

    /**
     * Set answer3
     * @param string $answer3
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setAnswer3($answer3) {
        return $this->setData(self::ANSWER3, $answer3);
    }

    /**
     * Get question4
     * @return string|null
     */
    public function getQuestion4() {
        return $this->_get(self::QUESTION4);
    }

    /**
     * Set question4
     * @param string $question4
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setQuestion4($question4) {
        return $this->setData(self::QUESTION4, $question4);
    }

    /**
     * Get answer4
     * @return string|null
     */
    public function getAnswer4() {
        return $this->_get(self::ANSWER4);
    }

    /**
     * Set answer4
     * @param string $answer4
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setAnswer4($answer4) {
        return $this->setData(self::ANSWER4, $answer4);
    }

    /**
     * Get question5
     * @return string|null
     */
    public function getQuestion5() {
        return $this->_get(self::QUESTION5);
    }

    /**
     * Set question5
     * @param string $question5
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setQuestion5($question5) {
        return $this->setData(self::QUESTION5, $question5);
    }

    /**
     * Get answer5
     * @return string|null
     */
    public function getAnswer5() {
        return $this->_get(self::ANSWER5);
    }

    /**
     * Set answer5
     * @param string $answer5
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setAnswer5($answer5) {
        return $this->setData(self::ANSWER5, $answer5);
    }

    /**
     * Get CreatedAt
     * @return string|null
     */
    public function getCreatedAt() {
        return $this->_get(self::CREATED_AT);
    }

    /**
     * Set CreatedAt
     * @param string $createdAt
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setCreatedAt($createdAt) {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

}
