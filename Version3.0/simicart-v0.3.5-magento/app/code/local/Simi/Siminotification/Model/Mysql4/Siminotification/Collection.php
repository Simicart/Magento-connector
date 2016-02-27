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
 * Siminotification Resource Collection Model
 * 
 * @category    
 * @package     Siminotification
 * @author      Developer
 */
class Simi_Siminotification_Model_Mysql4_Siminotification_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct(){
		parent::_construct();
		$this->_init('siminotification/siminotification');
	}
}