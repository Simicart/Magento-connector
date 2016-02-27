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
class Simi_Connector_Model_Design extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('connector/design');
    }
	
	public function getThemeByWebDevice($web_id, $device_id){
		$collection = $this->getCollection()
			->addFieldToFilter('website_id', array('eq' => $web_id))
			->addFieldToFilter('device_id', array('eq' => $device_id));
		return $collection->getFirstItem();
	}
	public function setTheme($web_id, $device_id, $color){
		$item = $this->getThemeByWebDevice($web_id, $device_id);
		$this->setData('theme_color', $color);
		$this->setId($item->getId())->save();
	}

}