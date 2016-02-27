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
 * Spotproduct Observer Model
 * 
 * @category    
 * @package     Spotproduct
 * @author      Developer
 */
class Simi_Spotproduct_Model_Observer
{
	/**
	 * process controller_action_predispatch event
	 *
	 * @return Simi_Spotproduct_Model_Observer
	 */
	public function controllerActionPredispatch($observer){
		$action = $observer->getEvent()->getControllerAction();
		return $this;
	}
}