<?php

class Simi_Simipromoteapp_Helper_DateTime extends Mage_Core_Helper_Abstract
{
    public function formatDateTime($time_format){
        return date('Y-m-d',strtotime($time_format));
    }

	public function getDateField($idField,$default_value = null){
		$form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => Mage::getUrl('*/*/save'),
            'method'    => 'post'
        ));
        $element = new Varien_Data_Form_Element_Date(
            array(
                'name' => $idField,
                'label' => Mage::helper('bundle')->__('Date'),
                'tabindex' => 1,
				'image' => Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'adminhtml/default/default/images/grid-cal.gif',
                'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_LONG),
                'value' => $default_value ==  null ? date('Y-m-d') : date('Y-m-d',strtotime($default_value)),
				'class' => 'required-entry'
            )
        );
        $element->setForm($form);
        $element->setId($idField);
        return $element->getElementHtml();
	}
	
	public function getFirstDateOfCurrentMonth(){
		return $this->formatDateTime('first day of this month');
	}
	
	public function getLastDateOfCurrentMonth(){
		return $this->formatDateTime('last day of this month');
	}

    /**
     * Creating date collection between two dates
     *
     * <code>
     * <?php
     * # Example 1
     * date_range("2014-01-01", "2014-01-20", "+1 day", "m/d/Y");
     *
     * # Example 2. you can use even time
     * date_range("01:00:00", "23:00:00", "+1 hour", "H:i:s");
     * </code>
     *
     * @author Ali OYGUR <alioygur@gmail.com>
     * @param string since any date, time or datetime format
     * @param string until any date, time or datetime format
     * @param string step
     * @param string date of output format
     * @return array
     */
    function date_range($first, $last, $step = '+1 day', $output_format = 'd/m/Y' ) {

        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while( $current <= $last ) {

            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }
}