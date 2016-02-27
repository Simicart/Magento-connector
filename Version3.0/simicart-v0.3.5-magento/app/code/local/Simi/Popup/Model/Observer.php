<?php
/
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
 * Popup Observer Model
 * 
 * @category    
 * @package     Popup
 * @author      Developer
 */
class Simi_Popup_Model_Observer
{
	/**
	 * process controller_action_predispatch event
	 *
	 * @return Simi_Popup_Model_Observer
	 */
	public function controllerActionPredispatch($observer){
		$action = $observer->getEvent()->getControllerAction();
		return $this;
	}
}