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

namespace Cybage\Attributemapping\Api\Data;

interface AttributesInterface extends \Magento\Framework\Api\ExtensibleDataInterface {

    const QUESTION3 = 'question_3';
    const SKU = 'sku';
    const MODEL_CODE = 'model_code';
    const QUESTION1 = 'question_1';
    const ATTRIBUTES_ID = 'attributes_id';
    const MODEL_NAME = 'model_name';
    const ANSWER3 = 'answer_3';
    const QUESTION2 = 'question_2';
    const ANSWER4 = 'answer_4';
    const QUESTION4 = 'question_4';
    const FOOTER_TITLE = 'footer_title';
    const SHORT_DESCRIPTION = 'short_description';
    const FOOTER_CONTENT = 'footer_content';
    const ANSWER2 = 'answer_2';
    const ANSWER5 = 'answer_5';
    const QUESTION5 = 'question_5';
    const ANSWER1 = 'answer_1';
    const SHORT_DESCRIPTOR = 'short_descriptor';
    const CREATED_AT = 'created_at';

    /**
     * Get attributes_id
     * @return string|null
     */
    public function getAttributesId();

    /**
     * Set attributes_id
     * @param string $attributesId
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setAttributesId($attributesId);

    /**
     * Get model_code
     * @return string|null
     */
    public function getModelCode();

    /**
     * Set model_code
     * @param string $modelCode
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setModelCode($modelCode);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Cybage\Attributemapping\Api\Data\AttributesExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Cybage\Attributemapping\Api\Data\AttributesExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
    \Cybage\Attributemapping\Api\Data\AttributesExtensionInterface $extensionAttributes
    );

    /**
     * Get model_name
     * @return string|null
     */
    public function getModelName();

    /**
     * Set model_name
     * @param string $modelName
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setModelName($modelName);

    /**
     * Get sku
     * @return string|null
     */
    public function getSku();

    /**
     * Set sku
     * @param string $sku
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setSku($sku);

    /**
     * Get short_description
     * @return string|null
     */
    public function getShortDescription();

    /**
     * Set short_description
     * @param string $shortDescription
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setShortDescription($shortDescription);

    /**
     * Get short_descriptor
     * @return string|null
     */
    public function getShortDescriptor();

    /**
     * Set short_descriptor
     * @param string $shortDescriptor
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setShortDescriptor($shortDescriptor);

    /**
     * Get footer_title
     * @return string|null
     */
    public function getFooterTitle();

    /**
     * Set footer_title
     * @param string $footerTitle
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setFooterTitle($footerTitle);

    /**
     * Get footer_content
     * @return string|null
     */
    public function getFooterContent();

    /**
     * Set footer_content
     * @param string $footerContent
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setFooterContent($footerContent);

    /**
     * Get question1
     * @return string|null
     */
    public function getQuestion1();

    /**
     * Set question1
     * @param string $question1
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setQuestion1($question1);

    /**
     * Get answer1
     * @return string|null
     */
    public function getAnswer1();

    /**
     * Set answer1
     * @param string $answer1
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setAnswer1($answer1);

    /**
     * Get question2
     * @return string|null
     */
    public function getQuestion2();

    /**
     * Set question2
     * @param string $question2
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setQuestion2($question2);

    /**
     * Get answer2
     * @return string|null
     */
    public function getAnswer2();

    /**
     * Set answer2
     * @param string $answer2
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setAnswer2($answer2);

    /**
     * Get question3
     * @return string|null
     */
    public function getQuestion3();

    /**
     * Set question3
     * @param string $question3
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setQuestion3($question3);

    /**
     * Get answer3
     * @return string|null
     */
    public function getAnswer3();

    /**
     * Set answer3
     * @param string $answer3
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setAnswer3($answer3);

    /**
     * Get question4
     * @return string|null
     */
    public function getQuestion4();

    /**
     * Set question4
     * @param string $question4
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setQuestion4($question4);

    /**
     * Get answer4
     * @return string|null
     */
    public function getAnswer4();

    /**
     * Set answer4
     * @param string $answer4
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setAnswer4($answer4);

    /**
     * Get question5
     * @return string|null
     */
    public function getQuestion5();

    /**
     * Set question5
     * @param string $question5
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setQuestion5($question5);

    /**
     * Get answer5
     * @return string|null
     */
    public function getAnswer5();

    /**
     * Set answer5
     * @param string $answer5
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setAnswer5($answer5);

    /**
     * Get createdAt
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set createdAt
     * @param string $createdAt
     * @return \Cybage\Attributemapping\Api\Data\AttributesInterface
     */
    public function setCreatedAt($createdAt);
}
