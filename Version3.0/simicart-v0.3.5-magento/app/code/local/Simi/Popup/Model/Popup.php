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
 * Popup Model
 * 
 * @category    
 * @package     Popup
 * @author      Developer
 */
class Simi_Popup_Model_Popup extends Mage_Core_Model_Abstract
{
	public function _construct(){
		parent::_construct();
		$this->_init('popup/popup');
	}
}