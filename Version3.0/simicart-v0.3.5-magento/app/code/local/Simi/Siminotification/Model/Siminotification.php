<?php
/**
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    
 * @package     Siminotification
 * @copyright   Copyright (c) 2012 
 * @license     
 */

 /**
 * Siminotification Model
 * 
 * @category    
 * @package     Siminotification
 * @author      Developer
 */
class Simi_Siminotification_Model_Siminotification extends Mage_Core_Model_Abstract
{
	public function _construct(){
		parent::_construct();
		$this->_init('siminotification/siminotification');
	}

	public function toOptionArray(){
		$platform = array(
						'1' => Mage::helper('siminotification')->__('Product In-app'), 
						'2' => Mage::helper('siminotification')->__('Category In-app'), 
						'3' => Mage::helper('siminotification')->__('Website Page'), 
					);
		return $platform;
	}
}