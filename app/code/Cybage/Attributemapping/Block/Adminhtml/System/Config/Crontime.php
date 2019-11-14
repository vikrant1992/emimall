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

namespace Cybage\Attributemapping\Block\Adminhtml\System\Config;

class Crontime extends \Magento\Config\Block\System\Config\Form\Field {

    public function getName($name) {
        if (strpos($name, '[]') === false) {
            $name .= '[]';
        }
        return $name;
    }

    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element) {

        $element->addClass('select');

        //radio button default values
        $everyMins = false;
        $everyWeekDays = false;
        $none = false;

        //mins and hrs default values
        $minValue = 0;
        $hrsValue = 0;
        $dayOfWeek = "*";

        if ($value = $element->getValue()) {
            $values = explode(',', $value);
            if (is_array($values)) {
                // Check the radio (every) postion
                $everyMins = ($values[0] == 'every') ? true : false;
                $everyWeekDays = ($values[1] == 'every') ? true : false;
                if (isset($values[4])) {
                    $none = ($values[4] == 'none') ? true : false;
                }
            }

            if ($everyMins == false && $everyWeekDays == false) {
                $none = true;
            }
        }

        $html = '<input type="hidden" id="' . $element->getHtmlId() . '" />';
        $html_for_min = '<div style="float:left;  margin:10px; width: 180px;">';
        // HTML for mins
        ($everyMins == true) ? $minValue = $values[1] : 0;
        $html_for_min .= $this->getRadioButtonHtml($this->getName($element->getName()), '70', '10', $everyMins);
        $html_for_min .= $this->getSelectHtml($this->getName($element->getName()), "Min", "100", "100", 5, 61, 5, $minValue);
        $html_for_min .= '</div>';

        //HTML for day of week
        $html_for_week_days = '<div style="float:left;  margin:10px; width: 365px;">';
        ($everyWeekDays == true) ? $dayOfWeek = $values[2] : $dayOfWeek = '*';
        $html_for_week_days .= $this->getRadioButtonHtml($this->getName($element->getName()), '70', '10', $everyWeekDays);
        $html_for_week_days .= $this->getWeekDaysHtml($this->getName($element->getName()), "Day of Week", "90", "75", $dayOfWeek);

        // HTML for hrs
        ($everyWeekDays == true) ? $hrsValue = $values[3] : $hrsValue = 0;
        $html_for_week_days .= $this->getSelectHtml($this->getName($element->getName()), "Hrs", "100", "70", 0, 24, 1, $hrsValue, 'at');

        // HTML for Mins
        ($everyWeekDays == true) ? $minValue = $values[4] : $minValue = 0;
        $html_for_week_days .= $this->getSelectHtml($this->getName($element->getName()), "Min", "100", "63", 0, 61, 5, $minValue, ':');
        $html_for_week_days .= '</div>';

        //HTML for None
        $html_for_none = '<div style="float:left;  margin:10px; width: 100px;">';
        $html_for_none .= $this->getRadioButtonHtml($this->getName($element->getName()), '70', '10', $none, "None");
        $html_for_none .= '</div>';

        $html .= $element->getAfterElementHtml();
        return $html_for_min . $html_for_week_days . $html_for_none . $html;
    }

    /**
     * This method will return radio button HTML
     * @param type $id
     * @param type $divWidth
     * @param type $innerWidth
     * @param type $status
     * @param type $customText
     * @return string
     */
    private function getRadioButtonHtml($id, $divWidth, $innerWidth, $status = 0, $customText = null) {

        $html = '<div style="float:left; margin: 5px 0 0; width: ' . $divWidth . 'px;">';
        if ($customText != null) {
            if ($status == 1) {
                $html .= '<input type="radio" id="' . $id . '" name="' . $id . '" value="' . strtolower($customText) . '" checked><span style="padding-left:5px">' . ucfirst($customText) . '</span></div>';
            } else {
                $html .= '<input type="radio" id="' . $id . '" name="' . $id . '" value="' . strtolower($customText) . '"><span style="padding-left:5px">' . ucfirst($customText) . '</span></div>';
            }
        } else {
            if ($status == 1) {
                $html .= '<input type="radio" id="' . $id . '" name="' . $id . '" value="every" checked><span style="padding-left:5px">Every</span></div>';
            } else {
                $html .= '<input type="radio" id="' . $id . '" name="' . $id . '" value="every"><span style="padding-left:5px">Every</span></div>';
            }
        }
        return $html;
    }

    private function getSelectHtml($elename, $text, $divWidth, $innerWidth, $startPostion, $endPosition, $incrementValue = 1, $selectValue, $customText = null) {
        $html = null;

        $html = '<div style="float:left;width: ' . $divWidth . 'px;">';
        if ($customText != null) {
            $html .= '<div style="float:left; padding-left:0px; padding-right:5px;padding-top:5px">' . $customText . '</div>';
        }
        $html .= '<select name="' . $elename . '" style="width:' . $innerWidth . 'px">' . "\n";

        if ($selectValue == "*") {
            $selectValue = 0;
        }

        for ($i = $startPostion; $i < $endPosition; $i = $i + $incrementValue) {
            if ($i == $selectValue) {
                if ($i == 0) {
                    if ($text == 'Min') {
                        $html .= '<option value="' . "0" . '" selected="selected">' . __("00 Min") . '</option>';
                    } elseif ($text == 'Hrs' or $text == 'Hourly') {
                        $html .= '<option value="' . "0" . '" selected="selected">' . __("12 AM ") . '</option>';
                    } else {
                        $html .= '<option value="' . "*" . '" selected="selected">' . __("Every $text") . '</option>';
                    }
                } else {
                    $am_limit = 11;
                    $pm_limit = 24;

                    if ($endPosition == 24 && $am_limit > $i) {
                        $text = 'AM';

                        $html .= '<option value="' . $i . '" selected="selected">' . __(sprintf("%02d", $i) . " $text") . '</option>';
                    } elseif ($endPosition == 24 && $i > $am_limit && $pm_limit > $i) {
                        $text = 'PM';
                        if (($i - 12) == 0) {
                            $html .= '<option value="' . $i . '" selected="selected">' . __(sprintf("%02d", 12) . " $text") . '</option>';
                        } else {
                            $html .= '<option value="' . $i . '" selected="selected">' . __(sprintf("%02d", ($i - 12)) . " $text") . '</option>';
                        }
                    } else {
                        $html .= '<option value="' . $i . '" selected="selected">' . __(sprintf("%02d", $i) . " $text") . '</option>';
                    }
                }
            } else {
                if ($i == 0) {
                    if ($text == 'Min') {
                        $html .= '<option value="' . "0" . '">' . __("00 Min") . '</option>';
                    } elseif ($text == 'Hrs' or $text == 'Hourly') {
                        $html .= '<option value="' . "0" . '" selected="selected">' . __("12 AM ") . '</option>';
                    } else {
                        $html .= '<option value="' . "*" . '">' . __("Every $text") . '</option>';
                    }
                } else {
                    $am_limit = 11;
                    $pm_limit = 24;
                    // echo $text;
                    if ($endPosition == 24 && $am_limit > $i) {
                        $text = 'AM';
                        $html .= '<option value="' . $i . '">' . __(sprintf("%02d", $i) . " $text") . '</option>';
                    } elseif ($endPosition == 24 && $i > $am_limit && $pm_limit > $i) {
                        $text = 'PM';
                        if (($i - 12) == 0) {
                            $html .= '<option value="' . $i . '">' . __(sprintf("%02d", 12) . " $text") . '</option>';
                        } else {
                            $html .= '<option value="' . $i . '">' . __(sprintf("%02d", ($i - 12)) . " $text") . '</option>';
                        }
                    } else {
                        $html .= '<option value="' . $i . '">' . __(sprintf("%02d", $i) . " $text") . '</option>';
                    }
                }
            }
        }

        $html .= '</select>';
        $html .= '</div>';
        return $html;
    }

    /**
     * This function will return week days Html
     * @param type $value
     * @return type
     */
    private function getWeekDaysHtml($elename, $text, $divWidth, $innerWidth, $value) {

        if ($value == '*') {
            $value = -1;
        }

        $selectString = 'selected="selected"';
        $html = '<div style="float:left;width: ' . $divWidth . 'px;">';
        $html .= '<select name="' . $elename . '" style="width:' . $innerWidth . 'px">' . "\n";

        $html .= ($value == -1 ) ? '<option value="*" selected="selected" >Day</option>' : '<option value="*" >Everyday</option>';
        $html .= ($value == 1) ? '<option value="1" selected="selected" >Monday</option>' : '<option value="1" >Monday</option>';
        $html .= ($value == 2) ? '<option value="2" selected="selected" >Tuesday</option>' : '<option value="2" >Tuesday</option>';
        $html .= ($value == 3) ? '<option value="3" selected="selected" >Wednesday</option>' : '<option value="3" >Wednesday</option>';
        $html .= ($value == 4) ? '<option value="4" selected="selected" >Thursday</option>' : '<option value="4" >Thursday</option>';
        $html .= ($value == 5) ? '<option value="5" selected="selected" >Friday</option>' : '<option value="5" >Friday</option>';
        $html .= ($value == 6) ? '<option value="6" selected="selected" >Saturday</option>' : '<option value="6" >Saturday</option>';
        $html .= ($value == 0) ? '<option value="0" selected="selected" >Sunday</option>' : '<option value="0" >Sunday</option>';
        $html .= '</select>';
        $html .= '</div>';

        return $html;
    }

}
