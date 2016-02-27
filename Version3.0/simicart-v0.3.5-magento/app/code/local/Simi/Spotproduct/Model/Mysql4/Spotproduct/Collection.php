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
 * Spotproduct Resource Collection Model
 * 
 * @category    
 * @package     Spotproduct
 * @author      Developer
 */
class Simi_Spotproduct_Model_Mysql4_Spotproduct_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct(){
		parent::_construct();
		$this->_init('spotproduct/spotproduct');
	}
}