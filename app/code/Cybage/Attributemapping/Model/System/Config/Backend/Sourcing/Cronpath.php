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

namespace Cybage\Attributemapping\Model\System\Config\Backend\Sourcing;

class Cronpath extends \Magento\Framework\App\Config\Value {

    protected $_runModelPath = '';

    public function __construct(\Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\App\Config\ScopeConfigInterface $config, \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList, \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, $runModelPath = '', array $data = []) {
        $this->_runModelPath = $runModelPath;

        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    /**
     * This function will return cron expression string
     * @param type $time
     * @return string
     */
    public function getCronExpression($time) {
        $cronExprString = null;
        if (is_array($time) && !empty($time)) {
            // Set default
            $everyMins = false;
            $everyWeekDays = false;
            $none = false;

            /*
             * Check the radio (every) postion
             */
            $everyMins = ($time[0] == 'every') ? true : false;
            $everyWeekDays = ($time[1] == 'every') ? true : false;
            $none = ($time[4] == 'none') ? true : false;

            if ($none == true) {
                $cronExprString = null;
            } else {
                if ($everyMins == true) {
                    $cronExprString = '*/' . $time[1] . ' * * * *';
                } else {
                    $cronExprString = $time[4] . ' ' . $time[3] . ' * * ' . $time[2];
                }
            }
        }

        return $cronExprString;
    }

}
