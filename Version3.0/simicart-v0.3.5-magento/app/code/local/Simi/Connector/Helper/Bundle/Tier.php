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
 * Connector Helper
 * 
 * @category    
 * @package     Connector
 * @author      Developer
 */
class Simi_Connector_Helper_Bundle_Tier extends Simi_Connector_Helper_Tier {

    public function addTier(&$data, $product) {
        $_product = $product;
		
	
        $_tierPrices = $this->getTierPrices($_product);		
        if (count($_tierPrices) > 0) {
            $stringHt = '';
            foreach ($_tierPrices as $_price) {
                $stringHt = Mage::helper('bundle')->__('Buy %1$s with %2$s discount each', $_price['price_qty'], ($_price['price'] * 1) . '%');
                $data['tier_price'][] = $stringHt;
            }
        }
    }

}

?>
