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
 * Connector Model
 * 
 * @category 	Magestore
 * @package 	Magestore_Connector
 * @author  	Magestore Developer
 */
class Simi_Connector_Model_Connector extends Simi_Connector_Model_Abstract {

	protected $_data;

    public function _construct() {
        parent::_construct();
        $this->_init('connector/connector');
    }

    public function changeData($data_change, $event_name, $event_value) {
        $this->_data = $data_change;
        // dispatchEvent to change data
        $this->eventChangeData($event_name, $event_value);
        return $this->getCacheData();
    }

    public function setCacheData($data, $module_name = '') {
        if ($module_name == "simi_connector") {
            $this->_data = $data;
            return;
        }
        if ($module_name == '' || is_null(Mage::getModel('connector/plugin')->checkPlugin($module_name)))
            return;
        $this->_data = $data;
    }

    public function getCacheData() {
        return $this->_data;
    }

    public function getHomeData($data, $device_id){
    	
    	$home_categories = Mage::getModel('simicategory/simicategory')->getCategoires();
    	$home_categories_data = $home_categories['data'];

    	$home_banner = Mage::getModel('connector/config_app')->getBannerList();
    	$home_banner_data = $home_banner['data'];

    	$home_stores = Mage::getModel('connector/switch')->getStores();
    	$home_stores_data = $home_stores['data'];

    	$home_spot_product = Mage::getModel('spotproduct/spotproduct')->getSpotProducts($data);
    	$home_spot_product_data = $home_spot_product['data'];

    	$home_data = array(        
            'categories' => $home_categories_data,
            'banner' => $home_banner_data,
            'spot_product' => $home_spot_product_data,         
    		);

    	$event_name = $this->getControllerName() . '_home_data';
        $event_value = array(
            'object' => $this,            
        );
        $home_data_change = $this->changeData($home_data, $event_name, $event_value);      

        $information = $this->statusSuccess();
        $information['data'] = array($home_data_change);        
    	return $information;
    }

    public function getSplashData($data, $device_id){
        //save currency!. 
        if(isset($data->currency) && $data->currency != ''){
             Mage::app()->getStore()->setCurrentCurrencyCode($data->currency);
        }       
        
        //save store view
        if (isset($data->store_id) && $data->store_id) {
            Mage::app()->getCookie()->set(Mage_Core_Model_Store::COOKIE_NAME, Mage::app()->getStore($data->store_id)->getCode(), TRUE);
            Mage::app()->setCurrentStore(
                    Mage::app()->getStore($data->store_id)->getCode()
            );
            Mage::getSingleton('core/locale')->emulate($data->store_id);
        }
        $home_store_view = Mage::getModel('connector/config_app')->getConfigApp();
        $home_store_view_data = $home_store_view['data'];

        $home_currenies =  Mage::getModel('simicategory/simicategory')->getCurrencies();
        $home_currenies_data = $home_currenies['data'];

        $home_cms = Mage::getModel('connector/config_app')->getMerchantInfo();
        $home_cms_data = $home_cms['data'];

        $home_plugin = Mage::getModel('connector/config_app')->getListPlugin($device_id);
        $home_plugin_data = $home_plugin['data'];
        
        $home_stores = Mage::getModel('connector/switch')->getStores();
        $home_stores_data = $home_stores['data'];       

        $home_data = array(          
            'store_view' => $home_store_view_data,   
            'cms' => $home_cms_data,    
            'plugin' => $home_plugin_data,
            'stores' => $home_stores_data,
            'currenies' => $home_currenies_data,
            );

        $event_name = $this->getControllerName() . '_splash_data';
        $event_value = array(
            'object' => $this,            
        );
        $home_data_change = $this->changeData($home_data, $event_name, $event_value);      

        $information = $this->statusSuccess();
        $information['data'] = array($home_data_change);        
        return $information;
    }
}