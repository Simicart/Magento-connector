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
class Simi_Connector_Model_Checkout_Address extends Simi_Connector_Model_Checkout {
		
	 
     public function getAddressBilling()
	 {        
            if ($this->customerLogin()) {
                return $this->_getCheckoutSession()->getQuote()->getBillingAddress();
                
            } else {
                return  Mage::getModel('sales/quote_address');
            }        		
    }
	
	public function getAddressShipping()
	 {        
            if ($this->customerLogin()) {
                return $this->_getCheckoutSession()->getQuote()->getShippingAddress();
                
            } else {
                return Mage::getModel('sales/quote_address');
            }        		
    }
}