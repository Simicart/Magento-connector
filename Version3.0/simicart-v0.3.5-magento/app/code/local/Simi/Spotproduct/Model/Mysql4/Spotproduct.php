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
 * Spotproduct Resource Model
 * 
 * @category    
 * @package     Spotproduct
 * @author      Developer
 */
class Simi_Spotproduct_Model_Mysql4_Spotproduct extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct(){
		$this->_init('spotproduct/spotproduct', 'spotproduct_id');
	}
}