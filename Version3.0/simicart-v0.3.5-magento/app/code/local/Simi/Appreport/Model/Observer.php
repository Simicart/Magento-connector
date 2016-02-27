<?php
/**
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    
 * @package     Appreport
 * @copyright   Copyright (c) 2012 
 * @license     
 */

/**
 * Appreport Observer Model
 * 
 * @category    
 * @package     Appreport
 * @author      Developer
 */
class Simi_Appreport_Model_Observer
{
    /**
     * process controller_action_predispatch event
     *
     * @return Simi_Appreport_Model_Observer
     */
    public function controllerActionPredispatch($observer)
    {
        $action = $observer->getEvent()->getControllerAction();
        return $this;
    }
    
     public function simiAppOrderPlacingCompleted($observer) {
        $connectorModule = Mage::app()->getRequest()->getControllerModule();
        if (($connectorModule != 'Simi_Connector')&&($connectorModule != 'Simi_PayPalExpress')) {
           return;
        }
        $orderId = $observer->getEvent()->getOrder()->getId();
        $newTransaction = Mage::getModel('appreport/appreport');
        $newTransaction->setOrderId($orderId);
        try {
            $newTransaction->save();
        } catch (Exception $exc) {
            
        }
    }
}