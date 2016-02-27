<?php
/**
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    
 * @package     Connector
 * @copyright   Copyright (c) 2012 
 * @license     
 */

/**
 * Connector Model
 * 
 * @category    
 * @package     Connector
 * @author      Developer
 */
class Simi_Connector_Model_Abstract extends Mage_Core_Model_Abstract {

    public function _helper() {
        return Mage::helper('connector');
    }

    public function getControllerName() {
        $request = Mage::app()->getFrontController()->getRequest();
        $name = $request->getRequestedRouteName() . '_' .
                $request->getRequestedControllerName() . '_' .
                $request->getRequestedActionName();
        return $name;
    }

    public function eventChangeData($name_event, $value) {
        Mage::dispatchEvent($name_event, $value);
    }

    public function statusSuccess() {
        return array('status' => 'SUCCESS',
            'message' => array('SUCCESS'),           
        );
    }

    public function statusError($error = array('NO DATA')) {
        return array(
            'status' => 'FAIL',
            'message' => $error,            
        );
    }
        
}