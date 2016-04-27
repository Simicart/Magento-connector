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
 * Config Controller
 * 
 * @category    
 * @package     Connector
 * @author      Developer
 */
class Simi_Connector_ConfigController extends Simi_Connector_Controller_Action {

    public function get_storesAction() {
        $information = Mage::getModel('connector/switch')->getStores();
        $this->_printDataJson($information);
    }

    public function get_store_viewAction() {
        $data = $this->getData();
        if ($data && $data->store_id) {
            Mage::app()->getCookie()->set(Mage_Core_Model_Store::COOKIE_NAME, Mage::app()->getStore($data->store_id)->getCode(), TRUE);
            Mage::app()->setCurrentStore(
                    Mage::app()->getStore($data->store_id)->getCode()
            );
            Mage::getSingleton('core/locale')->emulate($data->store_id);
        }
        $information = Mage::getModel('connector/config_app')->getConfigApp();
        $this->_printDataJson($information);
    }

    public function save_store_viewAction() {
        $data = $this->getData();
        $information = Mage::getModel('connector/config_app')->statusSuccess();
        if ($data && $data->store_id) {
            Mage::app()->setCurrentStore(
                    Mage::app()->getStore($data->store_id)->getCode()
            );
            Mage::getSingleton('core/locale')->emulate($data->store_id);
        } else {
            $information = Mage::getModel('connector/config_app')->statusError();
        }
        // Zend_debug::dump(Mage::app()->getStore()->getId());die();
        $this->_printDataJson($information);
    }

    public function get_bannerAction() {
        $information = Mage::getModel('connector/config_app')->getBannerList();
        $this->_printDataJson($information);
    }

    public function get_cms_pagesAction() {
        $information = Mage::getModel('connector/config_app')->getMerchantInfo();
        $this->_printDataJson($information);
    }

    //for cms is same  function up
    public function get_merchant_infoAction() {
        $information = Mage::getModel('connector/config_app')->getMerchantInfo();
        $this->_printDataJson($information);
    }
    //end cms

    public function register_deviceAction() {
        $data = $this->getData();
        $device_id = $this->getDeviceId();
        $information = Mage::getModel('connector/device')->setDataDevice($data, $device_id);
        $this->_printDataJson($information);
    }
	
	public function get_notification_listAction() {
        $data = $this->getData();
        $device_id = $this->getDeviceId();
        $information = Mage::getModel('connector/device')->getNotificationList($data, $device_id);
        $this->_printDataJson($information);
    }

    public function get_pluginsAction() {
        $device_id = $this->getDeviceId();
        $information = Mage::getModel('connector/config_app')->getListPlugin($device_id);
        $this->_printDataJson($information);
    }

    public function get_splash_dataAction(){
        $data = $this->getData();
        $device_id = $this->getDeviceId();
        $information = Mage::getModel('connector/connector')->getSplashData($data, $device_id);
        $this->_printDataJson($information);
    }

    public function get_home_dataAction(){
        $data = $this->getData();
        $device_id = $this->getDeviceId();
        $information = Mage::getModel('connector/connector')->getHomeData($data, $device_id);
        $this->_printDataJson($information);
    }


}
