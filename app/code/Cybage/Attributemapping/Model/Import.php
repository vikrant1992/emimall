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

namespace Cybage\Attributemapping\Model;

class Import extends \Magento\Framework\Model\AbstractModel {

    /**
     * @var \Magento\Catalog\Api\Data\ProductInterfaceFactory
     */
    private $productFactory;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * Constructor
     * @param \Magento\Framework\Model\Context $context
     * @param \Cybage\Attributemapping\Model\AttributesFactory $attributesFactory
     * @param \Magento\Framework\Stdlib\DateTime\DateTimeFactory $dateTimeFactory
     * @param \Magento\Catalog\Api\Data\ProductInterfaceFactory $productFactory
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     */
    public function __construct(
    \Magento\Framework\Model\Context $context, \Cybage\Attributemapping\Model\AttributesFactory $attributesFactory, \Magento\Framework\Stdlib\DateTime\DateTimeFactory $dateTimeFactory, \Magento\Catalog\Api\Data\ProductInterfaceFactory $productFactory, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        $this->attributesFactory = $attributesFactory;
        $this->dateTimeFactory = $dateTimeFactory;
        $this->productFactory = $productFactory;
        $this->productRepository = $productRepository;
    }

    /**
     * Function to save csv data into 
     * `cybage_attributemapping_attributes` table
     * @param type $dataRow
     */
    public function saveCsvData($dataRow) {
        $dateModel = $this->dateTimeFactory->create();
        $current_date = $dateModel->gmtDate();
        $model = $this->attributesFactory->create();
        $model->setModelCode($dataRow[0]);
        $model->setModelName($dataRow[1]);
        $model->setSku($dataRow[2]);
        $model->setShortDescription($dataRow[3]);
        $model->setShortDescriptor($dataRow[4]);
        $model->setFooterTitle($dataRow[5]);
        $model->setFooterContent($dataRow[6]);
        $model->setQuestion1($dataRow[7]);
        $model->setAnswer1($dataRow[8]);
        $model->setQuestion2($dataRow[9]);
        $model->setAnswer2($dataRow[10]);
        $model->setQuestion3($dataRow[11]);
        $model->setAnswer3($dataRow[12]);
        $model->setQuestion4($dataRow[13]);
        $model->setAnswer4($dataRow[14]);
        $model->setQuestion5($dataRow[15]);
        $model->setAnswer5($dataRow[16]);
        $model->setCreatedAt($current_date);
        $model->save();
    }

    /**
     * Function to save attribute values from csv
     * @param type $dataRow
     */
    public function saveAttributeValues($dataRow)
    {
        try {
            $faq = '';
            for ($i=1; $i<=5; $i++) {
                $que = 'question_'.$i;
                $ans = 'answer_'.$i;
                $faq .= '<div class="p_faqsdesign">
                            <a href="javascript:void(0);" class="active">
                                <p>'.$dataRow[$que].'</p> <img src="images/minus_gray.png" alt=""></a>
                            <p class="p_detabacks p_disdatablock">'.$dataRow[$ans].'</p>
                        </div>';
            }

            $footer = '<h4>' . $dataRow['footer_title'] . '</h4><p>' . $dataRow['footer_content'] . '</p>';

            $product = $this->productFactory->create();
            if ($product->getIdBySku($dataRow['sku'])) {
                $product->setSku($dataRow['sku']);
                $product->setCustomAttribute('model_code', $dataRow['model_code']);
                $product->setCustomAttribute('model_name', $dataRow['model_name']);
                $product->setCustomAttribute('short_descriptor_title', $dataRow['short_description']);
                $product->setCustomAttribute('short_descriptor', $dataRow['short_descriptor']);
                $product->setCustomAttribute('footer_content', $footer);
                $product->setCustomAttribute('faq', $faq);
                $this->productRepository->save($product);

                $model = $this->attributesFactory->create()
                        ->load($dataRow['attributes_id']);
                $model->setStatus(1);
                $model->save();
            } else {
                $model = $this->attributesFactory->create()
                        ->load($dataRow['attributes_id']);
                $model->setComments("SKU not found");
                $model->setStatus(0);
                $model->save();
            }
        } catch (Exception $e) {
            $model = $this->attributesFactory->create()
                    ->load($dataRow['attributes_id']);
            $model->setComments($e->getMessage());
            $model->setStatus(2);
            $model->save();
        }
    }

    /**
     * Function to map values to attributes
     */
    public function mappingValues() {
        $collection = $this->attributesFactory->create()
                ->getCollection()
                ->addFieldToFilter('status', 0);
        $dataRows = $collection->getData();
        foreach ($dataRows as $dataRow) {
            $this->saveAttributeValues($dataRow);
        }
    }

}
