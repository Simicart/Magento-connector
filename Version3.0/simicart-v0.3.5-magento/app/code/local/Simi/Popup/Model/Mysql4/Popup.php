<?php

/**
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    
 * @package     Popup
 * @copyright   Copyright (c) 2012 
 * @license    
 */

/**
 * Popup Resource Model
 * 
 * @category    
 * @package     Popup
 * @author      Developer
 */
class Simi_Popup_Model_Mysql4_Popup extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct(){
		$this->_init('popup/popup', 'popup_id');
	}
}