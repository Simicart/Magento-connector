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
class Simi_Connector_Model_Key extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('connector/key');
    }

    public function getKey($webId) {
        $collection = $this->getCollection()->addFieldToFilter('website_id', array('eq' => $webId));
        $app = Mage::getModel('connector/app')->getCollection()->addFieldToFilter('website_id', array('eq' => $webId));
		// Zend_debug::dump($collection->getData());die();
        if (!$app->getFirstItem()->getId()) {
            $data = Mage::helper('connector')->getDataDesgin();
            foreach ($data as $item) {               
                $model_a = Mage::getModel('connector/app');
                $model_a->setData($item);
                $model_a->setWebsiteId($webId);
                $model_a->save();
            }
        }
        return $collection->getFirstItem();
    }

    public function setKey($key, $webId) {
		// $webId = Mage::getBlockSingleton('connector/adminhtml_web_switcher')->getWebsiteId();
        $cache_key = $this->getKey($webId);
        $this->setData('key_secret', $key);
        $this->setData('website_id', $webId);
        if ($cache_key) {
            $this->setId($cache_key->getId());
        }
		
        $this->save();		
    }

}