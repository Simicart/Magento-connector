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
class Simi_Connector_Helper_Customize extends Mage_Core_Helper_Abstract {

	public function checkIdPackages($id){
		$packageIds = array(45, 44, 36, 37, 41);
		if(in_array($id, $packageIds)){
			return true;
		}
		return false;
	}

	public function checkPlugins($product_id){
		$data = array(
			'active' => '0',
			'label'  => 'Bought'
			);
		if(Mage::helper('usermanagement')->checkBuyOncePlugin($product_id)){
			$data['active'] = '1';
			$data['label'] = 'Buy Now';
		}
		return $data;
	}

	public function checkPackage($product_id){
		if($this->checkLogin()){
			$pIds = $this->checkOrder();
			$user = Mage::getModel('usermanagement/user')->load(Mage::getSingleton('customer/session')->getCustomer()->getId(), 'customer_id');
			$website = $user->getWebsite();
			$check_trial = Mage::getModel('usermanagement/plugin')->getCollection()
							->addFieldToFilter('website_id', $website->getId())
							->addFieldToFilter('platform', Simicart_UserManagement_Model_Platform::IPHONE)
							;
			$is_trial = sizeof($check_trial) > 0 ? true : false;
			$data = array();
			$data['active'] = '1';

			if($product_id == 45){
				if(sizeof($pIds) == 0){
					if($is_trial){
						$data['url'] = Mage::getUrl('connector/buy/free');
						$data['label'] = 'Got It';
						$data['active'] = '0';
					} else {
						$data['url'] = Mage::getUrl('connector/buy/free');
						$data['label'] = 'Get Now';
					}
				}else{
					$data['url'] = Mage::getUrl('connector/buy/free');
					$data['label'] = 'Got It';
					$data['active'] = '0';
				}
			}elseif($product_id == 44){
				if(sizeof($pIds) == 0){
					if($is_trial){
						$data['url'] = Mage::getUrl('connector/buy/upgradeSuperior');
						$data['label'] = 'Upgrade';
					} else {
						$data['url'] = Mage::getUrl('connector/buy/superior');
						$data['label'] = 'Buy Now';
					}
				}else{
					if(in_array(Simicart_UserManagement_Helper_Product::SUPERIOR_ID,$pIds)){
						$data['url'] = Mage::getUrl('connector/buy/superior');
						$data['label'] = 'Bought';
						$data['active'] = '0';
					} else {
						$data['url'] = Mage::getUrl('connector/buy/upgradeSuperior');
						$data['label'] = 'Upgrade';
					}
				}
			}elseif($product_id == 41){
				if(sizeof($pIds) == 0){
					if($is_trial){
						$data['url'] = Mage::getUrl('connector/buy/zara');
						$data['label'] = 'Upgrade';
					} else {
						$data['url'] = Mage::getUrl('connector/buy/zara');
						$data['label'] = 'Buy Now';
					}
				}else{
					if(in_array(Mage::helper('usermanagement')->getLiteId(),$pIds) || in_array(Mage::helper('usermanagement')->getUltimateId(),$pIds)
						|| in_array(Mage::helper('usermanagement')->getStandardId(),$pIds) || in_array(Mage::helper('usermanagement')->getPlatinumId(),$pIds)
						|| in_array(Mage::helper('usermanagement')->getPremiumId(),$pIds)
						|| in_array(Simicart_UserManagement_Helper_Product::ZARA_PACKAGE_ID,$pIds)
						|| in_array(Simicart_UserManagement_Helper_Product::SUPERIOR_ID,$pIds)
						){
						$data['url'] = Mage::getUrl('connector/buy/superior');
						$data['label'] = 'Bought';
						$data['active'] = '0';
					} else {
						$data['url'] = Mage::getUrl('connector/buy/zara');
						$data['label'] = 'Upgrade';
					}
				}
			}elseif($product_id == 37){
				//Zend_debug::dump($pIds);die('xxxx');
				if(sizeof($pIds) == 0){
					if($is_trial){
						$data['url'] = Mage::getUrl('connector/buy/upgradeUltimate');
						$data['label'] = 'Upgrade';
					} else {
						$data['url'] = Mage::getUrl('connector/buy/ultimate');
						$data['label'] = 'Buy Now';
					}
				}else{
					if(in_array(Mage::helper('usermanagement')->getUltimateId(),$pIds) 
						|| in_array(Mage::helper('usermanagement')->getPremiumId(),$pIds)
						|| in_array(Simicart_UserManagement_Helper_Product::SUPERIOR_ID,$pIds)
						//|| in_array(Simicart_UserManagement_Helper_Product::ZARA_PACKAGE_ID,$pIds)
						){
						$data['url'] = Mage::getUrl('connector/buy/superior');
						$data['label'] = 'Bought';
						$data['active'] = '0';
					} else {
						$data['url'] = Mage::getUrl('connector/buy/upgradeUltimate');
						$data['label'] = 'Upgrade';
					}
				}

			}elseif($product_id == 36){
				if(sizeof($pIds) == 0){
					if($is_trial){
						$data['url'] = Mage::getUrl('connector/buy/upgradeLite');
						$data['label'] = 'Upgrade';
					} else {
						$data['url'] = Mage::getUrl('connector/buy/lite');
						$data['label'] = 'Buy Now';
					}
				}else{
					if(in_array(Mage::helper('usermanagement')->getLiteId(),$pIds) || in_array(Mage::helper('usermanagement')->getUltimateId(),$pIds)
						|| in_array(Mage::helper('usermanagement')->getStandardId(),$pIds) || in_array(Mage::helper('usermanagement')->getPlatinumId(),$pIds)
						|| in_array(Mage::helper('usermanagement')->getPremiumId(),$pIds)
						|| in_array(Simicart_UserManagement_Helper_Product::SUPERIOR_ID,$pIds) 
						|| in_array(Simicart_UserManagement_Helper_Product::ZARA_PACKAGE_ID,$pIds)
						){
						$data['url'] = Mage::getUrl('connector/buy/superior');
						$data['label'] = 'Bought';
						$data['active'] = '0';
					} else {
						$data['url'] = Mage::getUrl('connector/buy/upgradeLite');
						$data['label'] = 'Upgrade';
					}
				}

			}
			return $data;

		}else{
			if($product_id == 45){
				return array(
					'url' => Mage::getUrl('connector/buy/free'),
					'label' => 'Get Now',
					'active' => '1',
					);
			}elseif ($product_id == 44) {
				return array(
					'url' => Mage::getUrl('connector/buy/superior'),
					'label' => 'Buy Now',
					'active' => '1',
					);
			}elseif ($product_id == 41) {
				return array(
					'url' => Mage::getUrl('connector/buy/zara'),
					'label' => 'Buy Now',
					'active' => '1',
					);
			}elseif ($product_id == 37) {
				return array(
					'url' => Mage::getUrl('connector/buy/ultimate'),
					'label' => 'Buy Now',
					'active' => '1',
					);
			}elseif ($product_id == 36) {
				return array(
					'url' => Mage::getUrl('connector/buy/lite'),
					'label' => 'Buy Now',
					'active' => '1',
					);
			}
		}
	}

	public function checkLogin(){
		return Mage::getSingleton('customer/session')->isLoggedIn();
	}

	public function checkOrder(){
		$allow_ids = Mage::helper('usermanagement')->getAllowIds();
		// customer id
		$customerId = Mage::getSingleton('customer/session')->getCustomer()->getId();

		// get list orders of customer
		$orders = Mage::getModel("sales/order")->getCollection()
				   ->addAttributeToSelect('status')
				   ->addAttributeToSelect('quote_id')
				   ->addAttributeToSelect('entity_id')
				   ->addFieldToFilter('customer_id', $customerId)
				   ->addAttributeToFilter('status', array('in' => array('complete')))
				   ->setOrder('created_at', 'desc');
		$order_count = sizeof($orders);
		if($order_count > 0){
			$productIds = array();
			$check = false;
			foreach($orders as $order){
				$items = $order->getAllVisibleItems();
				foreach($items as $item){
					if(in_array($item->getProductId(),$allow_ids)){
						$productIds[] = $item->getProductId();
						$check = true;
					}
					
 				}
			}
			if($check)
				return $productIds;
			else
				return array();
		} else {
			return array();
		}
		
	}
}