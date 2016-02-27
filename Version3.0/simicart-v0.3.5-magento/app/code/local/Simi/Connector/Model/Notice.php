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
class Simi_Connector_Model_Notice extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('connector/notice');
    }
	
	
	public function getDataNotice($device_id, $webstie){
		$collection = $this->getCollection()
			->addFieldToFilter('device_id', array('eq' => $device_id))
			->addFieldToFilter('website_id', array('eq' => $webstie));
		if (!$collection->getSize()){
			$this->setData('device_id', $device_id);
			$this->setData('website_id', $webstie);
			$this->save();
			return $this;
		}
		return $collection->getFirstItem();
	}
	
	public function setDataNotice($data){
		$this->setData('notice_title', $data['title']);
		$this->setData('notice_url', $data['url']);
		$this->setData('notice_content', $data['message']);
		$this->setData('notice_sanbox', $data['sand_box']);
		$this->setData('website_id', $data['web_id']);
		$this->setData('device_id', $data['device_c']);
		try{
			$this->save();
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		}		
	}
}