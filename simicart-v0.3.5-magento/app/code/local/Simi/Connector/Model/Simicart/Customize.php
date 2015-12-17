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
 * @category 	Magestore
 * @package 	Magestore_Connector
 * @copyright 	Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license 	http://www.magestore.com/license-agreement.html
 */

/**
 * Connector Model Catalog
 * 
 * @category 	Simi
 * @package 	Simi_Connector
 * @author  	Simi Developer
 */
class Simi_Connector_Model_Simicart_Customize extends Simi_Connector_Model_Abstract {
	public function checkLogin(){
		return Mage::getSingleton('customer/session')->isLoggedIn();
	}

	public function buyFree(){
		if(Mage::getSingleton('customer/session')->isLoggedIn()){
			$information = $this->statusSuccess();
            $information['message'] = array(Mage::helper('checkout')->__('Please go to SimiCart website and build your app now'));
            $inforcart = Mage::getModel('connector/checkout_cart')->getAllCart();
            $information['data'] = $inforcart;     
            return $information;
		}else{
			$information = $this->statusSuccess();
            $information['message'] = array(Mage::helper('checkout')->__('Please login before buying.'));
            return $information;
		}
	}

	public function buyLite(){
		$buy_once = Mage::helper('usermanagement')->checkBuyOnceCore();
		if($buy_once){
			$productIds = array(Mage::helper('usermanagement')->getLiteId());
			$cart = Mage::getSingleton("checkout/cart");
			$cart->init();
			
			$items = $cart->getItems();
			if(count($items) > 0){
				foreach($items as $item){
					$cart->removeItem($item->getId());
				}
			}
			// $products_to_add is something I made up... 
			// associative array of product_ids to an array of their custom options
			foreach ($productIds as $product_id) {
			  $product = Mage::getModel("catalog/product")->load($product_id);
			  $options = new Varien_Object(array("qty" => 1));

			  // some products may result in multiple products getting added to cart
			  // I believe this pulls them all and sets the custom options accordingly
			  $add_all = $product->getTypeInstance(true)
				  ->prepareForCartAdvanced($options, $product, Mage_Catalog_Model_Product_Type_Abstract::PROCESS_MODE_FULL);

			  foreach ($add_all as $add_me) {
				$item = Mage::getModel('sales/quote_item');
				$item->setStoreId(Mage::app()->getStore()->getId());
				$item->setOptions($add_me->getCustomOptions())
				  ->setProduct($add_me);

				$item->setQty(1);
				// $item->setCustomPrice(200);
				// $item->setOriginalCustomPrice(200);
				$cart->getQuote()->addItem($item);
			  }
			}
			
			// when done adding all the items, finally call save on the cart
			
			$cart->save();
			$session = Mage::getSingleton("core/session",  array("name"=>"frontend"));
			if($session->getData('is_discount') && $session->getData('coupon_discount') != ''){
				Mage::getSingleton("checkout/session")->setData("coupon_code",$session->getData('coupon_discount'));
				Mage::getModel('checkout/cart')->getQuote()->setCouponCode($session->getData('coupon_discount'))->collectTotals()->save();
				// Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
			}
			Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
			
			Mage::getSingleton('core/session')->addSuccess(Mage::helper('checkout')->__('Lite was added to your shopping cart.'));
			$information = $this->statusSuccess();
            $information['message'] = array(Mage::helper('checkout')->__('Lite was added to your shopping cart.'));
            $inforcart = Mage::getModel('connector/checkout_cart')->getAllCart();
            $information['data'] = $inforcart;    
            return $information;
		} else {
			Mage::getSingleton('core/session')->addError(Mage::helper('checkout')->__('You can only buy 1 Lite with your account'));
			$information = $this->statusSuccess();
            $information['message'] = array(Mage::helper('checkout')->__('You can only buy 1 Lite with your account.'));
            $inforcart = Mage::getModel('connector/checkout_cart')->getAllCart();
            $information['data'] = $inforcart;    
            return $information;
		}
	}

	public function buyUltimate(){
		$buy_once = Mage::helper('usermanagement')->checkBuyOnceCore();
		if($buy_once){
			$productIds = array(Mage::helper('usermanagement')->getUltimateId());
			$cart = Mage::getSingleton("checkout/cart");
			$cart->init();
			
			$items = $cart->getItems();
			if(count($items) > 0){
				foreach($items as $item){
					$cart->removeItem($item->getId());
				}
			}
			
			// $products_to_add is something I made up... 
			// associative array of product_ids to an array of their custom options
			foreach ($productIds as $product_id) {
			  $product = Mage::getModel("catalog/product")->load($product_id);
			  $option_id = null;
				$option_value = null;
				foreach ($product->getOptions() as $o) {
					$optionType = $o->getType();
					if(strcasecmp($optionType,'checkbox') == 0){
						$values = $o->getValues();
						foreach ($values as $k => $v) {
							if(strcasecmp($v->getSku(),'installation') == 0){
								$option_id = $v->getData('option_id');
								$option_value = $v->getData('option_type_id');
							}
						}
					}
					$values = $o->getValues();
				}
				
				if($option_id && $option_value){
					$options = new Varien_Object(array("qty" => 1,"options" => array(
								$option_id => array(
											  "0" => $option_value
											)
							 )));

				} else {
					$options = new Varien_Object(array("qty" => 1));
				}

			  // some products may result in multiple products getting added to cart
			  // I believe this pulls them all and sets the custom options accordingly
			  $add_all = $product->getTypeInstance(true)
				  ->prepareForCartAdvanced($options, $product, Mage_Catalog_Model_Product_Type_Abstract::PROCESS_MODE_FULL);

			  foreach ($add_all as $add_me) {
				$item = Mage::getModel('sales/quote_item');
				$item->setStoreId(Mage::app()->getStore()->getId());
				$item->setOptions($add_me->getCustomOptions())
				  ->setProduct($add_me);

				$item->setQty(1);
				$cart->getQuote()->addItem($item);
			  }
			}
			
			// when done adding all the items, finally call save on the cart
			
			$cart->save();
			$session = Mage::getSingleton("core/session",  array("name"=>"frontend"));
			if($session->getData('is_discount') && $session->getData('coupon_discount') != ''){
				Mage::getSingleton("checkout/session")->setData("coupon_code",$session->getData('coupon_discount'));
				Mage::getModel('checkout/cart')->getQuote()->setCouponCode($session->getData('coupon_discount'))->collectTotals()->save();
				// Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
			}
			Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
			Mage::getSingleton('core/session')->addSuccess(Mage::helper('checkout')->__('Ultimate was added to your shopping cart.'));
			$information = $this->statusSuccess();
            $information['message'] = array(Mage::helper('checkout')->__('Ultimate was added to your shopping cart.'));
            $inforcart = Mage::getModel('connector/checkout_cart')->getAllCart();
            $information['data'] = $inforcart;    
            return $information;
		} else {
			Mage::getSingleton('core/session')->addError(Mage::helper('checkout')->__('You can only buy 1 Ultimate with your account'));
			$information = $this->statusSuccess();
            $information['message'] = array(Mage::helper('checkout')->__('You can only buy 1 Ultimate with your account'));
            $inforcart = Mage::getModel('connector/checkout_cart')->getAllCart();
            $information['data'] = $inforcart;    
            return $information;
		}
	}

	public function buySuperior()
	{
		$buy_once = Mage::helper('usermanagement')->checkBuyOnceCore();
		if($buy_once){
			$productIds = array(Simicart_UserManagement_Helper_Product::SUPERIOR_ID);
			$cart = Mage::getSingleton("checkout/cart");
			$cart->init();
			
			$items = $cart->getItems();
			if(count($items) > 0){
				foreach($items as $item){
					$cart->removeItem($item->getId());
				}
			}
			
			// $products_to_add is something I made up... 
			// associative array of product_ids to an array of their custom options
			foreach ($productIds as $product_id) {
				// Zend_debug::dump($product_id);die();
			  $product = Mage::getModel("catalog/product")->load($product_id);
			  $option_id = null;
				$option_value = null;
				foreach ($product->getOptions() as $o) {
					$optionType = $o->getType();
					if(strcasecmp($optionType,'checkbox') == 0){
						$values = $o->getValues();
						foreach ($values as $k => $v) {
							if(strcasecmp($v->getSku(),'installation') == 0){
								$option_id = $v->getData('option_id');
								$option_value = $v->getData('option_type_id');
							}
						}
					}
					$values = $o->getValues();
				}
				
				if($option_id && $option_value){
					$options = new Varien_Object(array("qty" => 1,"options" => array(
								$option_id => array(
											  "0" => $option_value
											)
							 )));

				} else {
					$options = new Varien_Object(array("qty" => 1));
				}

			  // some products may result in multiple products getting added to cart
			  // I believe this pulls them all and sets the custom options accordingly
			  $add_all = $product->getTypeInstance(true)
				  ->prepareForCartAdvanced($options, $product, Mage_Catalog_Model_Product_Type_Abstract::PROCESS_MODE_FULL);

			  foreach ($add_all as $add_me) {
				$item = Mage::getModel('sales/quote_item');
				$item->setStoreId(Mage::app()->getStore()->getId());
				$item->setOptions($add_me->getCustomOptions())
				  ->setProduct($add_me);

				$item->setQty(1);
				$cart->getQuote()->addItem($item);
			  }
			}
			
			// when done adding all the items, finally call save on the cart
			
			$cart->save();
			$session = Mage::getSingleton("core/session",  array("name"=>"frontend"));
			if($session->getData('is_discount') && $session->getData('coupon_discount') != ''){
				Mage::getSingleton("checkout/session")->setData("coupon_code",$session->getData('coupon_discount'));
				Mage::getModel('checkout/cart')->getQuote()->setCouponCode($session->getData('coupon_discount'))->collectTotals()->save();
				// Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
			}
			Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
			Mage::getSingleton('core/session')->addSuccess(Mage::helper('checkout')->__('Superior was added to your shopping cart.'));
			$information = $this->statusSuccess();
            $information['message'] = array(Mage::helper('checkout')->__('Superior was added to your shopping cart.'));
            $inforcart = Mage::getModel('connector/checkout_cart')->getAllCart();
            $information['data'] = $inforcart;    
            return $information;
		} else {
			Mage::getSingleton('core/session')->addError(Mage::helper('checkout')->__('You can only buy 1 Complete with your account'));
			$information = $this->statusSuccess();
            $information['message'] = array(Mage::helper('checkout')->__('You can only buy 1 Complete with your account.'));
            $inforcart = Mage::getModel('connector/checkout_cart')->getAllCart();
            $information['data'] = $inforcart;    
            return $information;
		}
	}

	public function buyZara(){
		$buy_once = Mage::helper('usermanagement')->checkBuyOnceCore();
		if($buy_once){
			$productIds = array(Simicart_UserManagement_Helper_Product::ZARA_PACKAGE_ID);
			$cart = Mage::getSingleton("checkout/cart");
			$cart->init();
			
			$items = $cart->getItems();
			if(count($items) > 0){
				foreach($items as $item){
					$cart->removeItem($item->getId());
				}
			}
			
			// $products_to_add is something I made up... 
			// associative array of product_ids to an array of their custom options
			foreach ($productIds as $product_id) {
			  $product = Mage::getModel("catalog/product")->load($product_id);
			  $options = new Varien_Object(array("qty" => 1));

			  // some products may result in multiple products getting added to cart
			  // I believe this pulls them all and sets the custom options accordingly
			  $add_all = $product->getTypeInstance(true)
				  ->prepareForCartAdvanced($options, $product, Mage_Catalog_Model_Product_Type_Abstract::PROCESS_MODE_FULL);
				   // Zend_debug::dump($add_all);die();
			  foreach ($add_all as $add_me) {
				$item = Mage::getModel('sales/quote_item');
				$item->setStoreId(Mage::app()->getStore()->getId());
				$item->setOptions($add_me->getCustomOptions())
				  ->setProduct($add_me);


				$item->setQty(1);
				// $item->setCustomPrice(200);
				// $item->setOriginalCustomPrice(200);
				$cart->getQuote()->addItem($item);
			  }
			}
			
			// when done adding all the items, finally call save on the cart
			
			$cart->save();
			$session = Mage::getSingleton("core/session",  array("name"=>"frontend"));
			if($session->getData('is_discount') && $session->getData('coupon_discount') != ''){
				Mage::getSingleton("checkout/session")->setData("coupon_code",$session->getData('coupon_discount'));
				Mage::getModel('checkout/cart')->getQuote()->setCouponCode($session->getData('coupon_discount'))->collectTotals()->save();
				// Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
			}
			Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
			
			Mage::getSingleton('core/session')->addSuccess(Mage::helper('checkout')->__('Zara was added to your shopping cart.'));
			$information = $this->statusSuccess();
            $information['message'] = array(Mage::helper('checkout')->__('Zara was added to your shopping cart.'));
            $inforcart = Mage::getModel('connector/checkout_cart')->getAllCart();
            $information['data'] = $inforcart;    
            return $information;
		} else {
			Mage::getSingleton('core/session')->addError(Mage::helper('checkout')->__('You can not buy Zara with your account'));
			$information = $this->statusError();
            $information['message'] = array(Mage::helper('checkout')->__('You can not buy Zara with your account'));
            $inforcart = Mage::getModel('connector/checkout_cart')->getAllCart();
            $information['data'] = $inforcart;    
            return $information;
		}
	}

	//upgrade package

	public function upgradeSuperior(){
		// customer id
		$customerId = Mage::getSingleton('customer/session')->getCustomer()->getId();

		// get list orders of customer
		$orders = Mage::getModel("sales/order")->getCollection()
				   ->addAttributeToSelect('*')
				   ->addFieldToFilter('customer_id', $customerId)
				   ->addAttributeToFilter('status', array('in' => array('complete')))
				   ->setOrder('created_at', 'asc');
		$order_count = sizeof($orders);
		$redirect_pricing = false;
		
		$starter = Mage::getModel('catalog/product')->load(Mage::helper('usermanagement')->getStarterId());
		$enhanced = Mage::getModel('catalog/product')->load(Mage::helper('usermanagement')->getLiteId());
		$ultimate = Mage::getModel('catalog/product')->load(Mage::helper('usermanagement')->getUltimateId());
		$platium = Mage::getModel('catalog/product')->load(Mage::helper('usermanagement')->getPlatinumId());
		$superior = Mage::getModel('catalog/product')->load(Simicart_UserManagement_Helper_Product::SUPERIOR_ID);

		if($order_count > 0){
			
			$price_upgrade = 0;
			$price_core = 0;
			foreach($orders as $order){
				$items = $order->getAllVisibleItems();
				foreach($items as $item){
					if($item->getProductId() == Simicart_UserManagement_Helper_Product::SUPERIOR_ID){
						$redirect_pricing = true;
						break;
					} else if($item->getProductId() == Mage::helper('usermanagement')->getLiteId() || $item->getProductId() == Mage::helper('usermanagement')->getStandardId()){
						if($price_core < $enhanced->getPrice()){
							$price_core = $enhanced->getPrice();
						}						
						
					} else if($item->getProductId() == Mage::helper('usermanagement')->getPlatinumId()){
						if($price_core < $platium->getPrice()){
							$price_core = $platium->getPrice();
						}	

					} else if($item->getProductId() == Mage::helper('usermanagement')->getStarterId() || $item->getProductId() == Mage::helper('usermanagement')->getCoreId()){
						if($price_core < $starter->getPrice()){
							$price_core = $starter->getPrice();
						}							
					
					} else if($item->getProductId() == Mage::helper('usermanagement')->getUltimateId() || $item->getProductId() == Mage::helper('usermanagement')->getPremiumId()){
						//$price_core += $ultimate->getPrice();
						if($price_core < $ultimate->getPrice()){
							$price_core = $ultimate->getPrice();
						}
					}
					else {
						$prices += $item->getProduct()->getPrice();
					}
 				}
			}
			
			$price_upgrade = $price_core + $prices;
			if($price_upgrade < $superior->getPrice())
				$price_upgrade = $superior->getPrice() - $price_upgrade;
			else 
				$price_upgrade = $superior->getPrice() - $price_core;
		}
		
		// process cart
		if($redirect_pricing){
			Mage::getSingleton('core/session')->addError(Mage::helper('checkout')->__('You can only buy 1 Superior with your account'));
			$information = $this->statusSuccess();
			$inforcart = Mage::getModel('connector/checkout_cart')->getAllCart();
            $information['data'] = $inforcart;    
            $information['message'] = array(Mage::helper('checkout')->__('You can only buy 1 Superior with your account'));
            return $information;
			// exit;
		}
		$cart = Mage::getSingleton("checkout/cart");
		$cart->init();
		
		$items = $cart->getItems();
		if(count($items) > 0){
			foreach($items as $item){
				$cart->removeItem($item->getId());
			}
		}
		
		// $products_to_add is something I made up... 
		// associative array of product_ids to an array of their custom options
		  $option_id = null;
			$option_value = null;
			foreach ($ultimate->getOptions() as $o) {
				$optionType = $o->getType();
				if(strcasecmp($optionType,'checkbox') == 0){
					$values = $o->getValues();
					foreach ($values as $k => $v) {
						if(strcasecmp($v->getSku(),'pro_install') == 0){
							$option_id = $v->getData('option_id');
							$option_value = $v->getData('option_type_id');
						}
					}
				}
				$values = $o->getValues();
			}
			
			if($option_id && $option_value){
				$options = new Varien_Object(array("qty" => 1,"options" => array(
							$option_id => array(
										  "0" => $option_value
										)
						 )));

			} else {
				$options = new Varien_Object(array("qty" => 1));
			}

		  // some products may result in multiple products getting added to cart
		  // I believe this pulls them all and sets the custom options accordingly
		  $add_all = $superior->getTypeInstance(true)
			  ->prepareForCartAdvanced($options, $superior, Mage_Catalog_Model_Product_Type_Abstract::PROCESS_MODE_FULL);

		  foreach ($add_all as $add_me) {
			$item = Mage::getModel('sales/quote_item');
			$item->setStoreId(Mage::app()->getStore()->getId());
			$item->setOptions($add_me->getCustomOptions())
			  ->setProduct($add_me);

			$item->setQty(1);
			if($price_upgrade){
				$item->setCustomPrice($price_upgrade);
				$item->setOriginalCustomPrice($price_upgrade);
			}
			$cart->getQuote()->addItem($item);
		  }
		
		
		// when done adding all the items, finally call save on the cart
		
		$cart->save();
		$session = Mage::getSingleton("core/session",  array("name"=>"frontend"));
		if($session->getData('is_discount') && $session->getData('coupon_discount') != ''){
			Mage::getSingleton("checkout/session")->setData("coupon_code",$session->getData('coupon_discount'));
			Mage::getModel('checkout/cart')->getQuote()->setCouponCode($session->getData('coupon_discount'))->collectTotals()->save();
			// Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
		}
		Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
		Mage::getSingleton('core/session')->addSuccess(Mage::helper('checkout')->__('Superior was added to your shopping cart.'));
		$information = $this->statusSuccess();
        $information['message'] = array(Mage::helper('checkout')->__('Superior was added to your shopping cart.'));
        $inforcart = Mage::getModel('connector/checkout_cart')->getAllCart();
            $information['data'] = $inforcart;    
        return $information;
	}

	public function upgradeLite(){
		// customer id
		$customerId = Mage::getSingleton('customer/session')->getCustomer()->getId();

		// get list orders of customer
		$orders = Mage::getModel("sales/order")->getCollection()
				   ->addAttributeToSelect('*')
				   ->addFieldToFilter('customer_id', $customerId)
				   ->addAttributeToFilter('status', array('in' => array('complete')))
				   ->setOrder('created_at', 'desc');
		$order_count = sizeof($orders);
		$redirect_pricing = false;
		$enhanced = Mage::getModel('catalog/product')->load(Mage::helper('usermanagement')->getLiteId());
		$starter = Mage::getModel('catalog/product')->load(Mage::helper('usermanagement')->getStarterId());
		if($order_count > 0){
			
			$price_upgrade = 0;
			$price_core = 0;
			$price_plugins = 0;
			foreach($orders as $order){
				$items = $order->getAllVisibleItems();
				foreach($items as $item){
					if($item->getProductId() == Mage::helper('usermanagement')->getUltimateId() || $item->getProductId() == Mage::helper('usermanagement')->getPremiumId() 
						|| $item->getProductId() == Mage::helper('usermanagement')->getPlatinumId()){
						$redirect_pricing = true;
						break;
					} else if($item->getProductId() == Mage::helper('usermanagement')->getStarterId() || $item->getProductId() == Mage::helper('usermanagement')->getCoreId()){
						// $price_upgrade = $platium->getPrice() - $enhanced->getPrice();
						if($price_core < $starter->getPrice()){
							$price_core = $starter->getPrice();	
						}
						
					} else {
						$product = $item->getProduct();
						$price_plugins += $product->getPrice();
					}
 				}
			}
			$price_upgrade = $price_core + $price_plugins;
			if($price_upgrade < $enhanced->getPrice())
				$price_upgrade = $enhanced->getPrice() - $price_upgrade;
			else 
				$price_upgrade = $enhanced->getPrice() - $price_core;
		}
		// var_dump($redirect_pricing);
		// process cart
		if($redirect_pricing){
			Mage::getSingleton('core/session')->addError(Mage::helper('checkout')->__('You can only buy 1 Lite with your account'));
			$information = $this->statusSuccess();
            $information['message'] = array(Mage::helper('checkout')->__('You can only buy 1 Lite with your account.'));
            $inforcart = Mage::getModel('connector/checkout_cart')->getAllCart();
            $information['data'] = $inforcart;    
            return $information;
			// exit;
		}
		
		$cart = Mage::getSingleton("checkout/cart");
		$cart->init();
		
		$items = $cart->getItems();
		if(count($items) > 0){
			foreach($items as $item){
				$cart->removeItem($item->getId());
			}
		}
		
		$options = new Varien_Object(array("qty" => 1));

		$add_all = $enhanced->getTypeInstance(true)
			->prepareForCartAdvanced($options, $enhanced, Mage_Catalog_Model_Product_Type_Abstract::PROCESS_MODE_FULL);

		foreach ($add_all as $add_me) {
			$item = Mage::getModel('sales/quote_item');
			$item->setStoreId(Mage::app()->getStore()->getId());
			$item->setOptions($add_me->getCustomOptions())
			  ->setProduct($add_me);

			$item->setQty(1);
			if($price_upgrade){
				$item->setCustomPrice($price_upgrade);
				$item->setOriginalCustomPrice($price_upgrade);
			}
			$cart->getQuote()->addItem($item);
		}
		
		// when done adding all the items, finally call save on the cart
		
		$cart->save();
		$session = Mage::getSingleton("core/session",  array("name"=>"frontend"));
		if($session->getData('is_discount') && $session->getData('coupon_discount') != ''){
			Mage::getSingleton("checkout/session")->setData("coupon_code",$session->getData('coupon_discount'));
			Mage::getModel('checkout/cart')->getQuote()->setCouponCode($session->getData('coupon_discount'))->collectTotals()->save();
			// Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
		}
		Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
		Mage::getSingleton('core/session')->addSuccess(Mage::helper('checkout')->__('Lite was added to your shopping cart.'));
		$information = $this->statusSuccess();
        $information['message'] = array(Mage::helper('checkout')->__('Lite was added to your shopping cart.'));
        $inforcart = Mage::getModel('connector/checkout_cart')->getAllCart();
        $information['data'] = $inforcart;    
        return $information;
	}

	public function upgradeUltimate(){
		// customer id
		$customerId = Mage::getSingleton('customer/session')->getCustomer()->getId();

		// get list orders of customer
		$orders = Mage::getModel("sales/order")->getCollection()
				   ->addAttributeToSelect('*')
				   ->addFieldToFilter('customer_id', $customerId)
				   ->addAttributeToFilter('status', array('in' => array('complete')))
				   ->setOrder('created_at', 'asc');
		$order_count = sizeof($orders);
		$redirect_pricing = false;
		
		$starter = Mage::getModel('catalog/product')->load(Mage::helper('usermanagement')->getStarterId());
		$enhanced = Mage::getModel('catalog/product')->load(Mage::helper('usermanagement')->getLiteId());
		$ultimate = Mage::getModel('catalog/product')->load(Mage::helper('usermanagement')->getUltimateId());
		$platium = Mage::getModel('catalog/product')->load(Mage::helper('usermanagement')->getPlatinumId());
		
		if($order_count > 0){
			
			$price_upgrade = 0;
			$price_core = 0;
			foreach($orders as $order){
				$items = $order->getAllVisibleItems();
				foreach($items as $item){
					if($item->getProductId() == Mage::helper('usermanagement')->getUltimateId() || $item->getProductId() == Mage::helper('usermanagement')->getPremiumId()){
						$redirect_pricing = true;
						break;
					} else if($item->getProductId() == Mage::helper('usermanagement')->getLiteId() || $item->getProductId() == Mage::helper('usermanagement')->getStandardId()){
						//$price_core += $enhanced->getPrice();
						if($price_core < $enhanced->getPrice()){
							$price_core = $enhanced->getPrice();	
						}
					} else if($item->getProductId() == Mage::helper('usermanagement')->getPlatinumId()){
						///$price_core += $platium->getPrice();
						if($price_core < $platium->getPrice()){
							$price_core = $platium->getPrice();	
						}
					} else if($item->getProductId() == Mage::helper('usermanagement')->getStarterId() || $item->getProductId() == Mage::helper('usermanagement')->getCoreId()){
						//$price_core += $starter->getPrice();
						if($price_core < $starter->getPrice()){
							$price_core = $starter->getPrice();	
						}
					
					} else {
						$prices += $item->getProduct()->getPrice();
					}
 				}
			}
			
			$price_upgrade = $price_core + $prices;
			if($price_upgrade < $ultimate->getPrice())
				$price_upgrade = $ultimate->getPrice() - $price_upgrade;
			else 
				$price_upgrade = $ultimate->getPrice() - $price_core;
		}
		
		// process cart
		if($redirect_pricing){
			Mage::getSingleton('core/session')->addError(Mage::helper('checkout')->__('You can only buy 1 Ultimate with your account'));
			$information = $this->statusSuccess();
            $information['message'] = array(Mage::helper('checkout')->__('You can only buy 1 Ultimate with your account.'));
            $inforcart = Mage::getModel('connector/checkout_cart')->getAllCart();
            $information['data'] = $inforcart;    
            return $information;
			// exit;
		}
		$cart = Mage::getSingleton("checkout/cart");
		$cart->init();
		
		$items = $cart->getItems();
		if(count($items) > 0){
			foreach($items as $item){
				$cart->removeItem($item->getId());
			}
		}
		
		// $products_to_add is something I made up... 
		// associative array of product_ids to an array of their custom options
		  $option_id = null;
			$option_value = null;
			foreach ($ultimate->getOptions() as $o) {
				$optionType = $o->getType();
				if(strcasecmp($optionType,'checkbox') == 0){
					$values = $o->getValues();
					foreach ($values as $k => $v) {
						if(strcasecmp($v->getSku(),'pro_install') == 0){
							$option_id = $v->getData('option_id');
							$option_value = $v->getData('option_type_id');
						}
					}
				}
				$values = $o->getValues();
			}
			
			if($option_id && $option_value){
				$options = new Varien_Object(array("qty" => 1,"options" => array(
							$option_id => array(
										  "0" => $option_value
										)
						 )));

			} else {
				$options = new Varien_Object(array("qty" => 1));
			}

		  // some products may result in multiple products getting added to cart
		  // I believe this pulls them all and sets the custom options accordingly
		  $add_all = $ultimate->getTypeInstance(true)
			  ->prepareForCartAdvanced($options, $ultimate, Mage_Catalog_Model_Product_Type_Abstract::PROCESS_MODE_FULL);

		  foreach ($add_all as $add_me) {
			$item = Mage::getModel('sales/quote_item');
			$item->setStoreId(Mage::app()->getStore()->getId());
			$item->setOptions($add_me->getCustomOptions())
			  ->setProduct($add_me);

			$item->setQty(1);
			if($price_upgrade){
				$item->setCustomPrice($price_upgrade);
				$item->setOriginalCustomPrice($price_upgrade);
			}
			$cart->getQuote()->addItem($item);
		  }
		
		
		// when done adding all the items, finally call save on the cart
		
		$cart->save();
		$session = Mage::getSingleton("core/session",  array("name"=>"frontend"));
		if($session->getData('is_discount') && $session->getData('coupon_discount') != ''){
			Mage::getSingleton("checkout/session")->setData("coupon_code",$session->getData('coupon_discount'));
			Mage::getModel('checkout/cart')->getQuote()->setCouponCode($session->getData('coupon_discount'))->collectTotals()->save();
			// Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
		}
		Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
		Mage::getSingleton('core/session')->addSuccess(Mage::helper('checkout')->__('Ultimate was added to your shopping cart.'));
		$information = $this->statusSuccess();
        $information['message'] = array(Mage::helper('checkout')->__('Ultimate was added to your shopping cart.'));
        $inforcart = Mage::getModel('connector/checkout_cart')->getAllCart();
        $information['data'] = $inforcart;    			
        return $information;
	}
}