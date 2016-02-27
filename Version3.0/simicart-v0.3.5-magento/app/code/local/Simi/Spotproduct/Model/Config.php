<?php
/**
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    
 * @package     Spotproduct
 * @copyright   Copyright (c) 2012 
 * @license     
 */

 /**
 * Spotproduct Model
 * 
 * @category    
 * @package     Spotproduct
 * @author      Developer
 */
class Simi_Spotproduct_Model_Config {

    public function toOptionArray() {
        return array(
            array('value' => '1', 'label' => Mage::helper('core')->__('Products Best Seller')),
            array('value' => '2', 'label' => Mage::helper('core')->__('Products Most View')),
            array('value' => '3', 'label' => Mage::helper('core')->__('Products New Update')),
            array('value' => '4', 'label' => Mage::helper('core')->__('Products Recently Added')));
    }

}