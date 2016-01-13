<?php
/**
 * Magestore
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    Magestore
 * @package     Magestore_Appreport
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

/**
 * Appreport Observer Model
 * 
 * @category    Magestore
 * @package     Magestore_Appreport
 * @author      Magestore Developer
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
        if (Mage::app()->getRequest()->getControllerModule() != 'Simi_Connector') {
           return;
        }
        $orderId = $observer['order_ids'][0];
        $newTransaction = Mage::getModel('appreport/appreport');
        $newTransaction->setOrderId($orderId);
        try {
            $newTransaction->save();
        } catch (Exception $exc) {
            
        }
    }
}