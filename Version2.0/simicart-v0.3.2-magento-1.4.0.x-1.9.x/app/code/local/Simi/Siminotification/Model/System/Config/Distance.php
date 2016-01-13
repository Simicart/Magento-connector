<?php

class Simi_Siminotification_Model_System_Config_Distance {

    public function toOptionArray() {
        $options = array(
            array('value' => 'km', 'label' => Mage::helper('siminotification')->__('Kilometers')),
            array('value' => 'mi', 'label' => Mage::helper('siminotification')->__('Miles')),
        );
        return $options;
    }

}