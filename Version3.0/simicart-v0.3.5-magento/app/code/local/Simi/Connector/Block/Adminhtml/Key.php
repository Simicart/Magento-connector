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
 * Connector Adminhtml Block
 * 
 * @category    
 * @package     Connector
 * @author      Developer
 */
class Simi_Connector_Block_Adminhtml_Key extends Mage_Adminhtml_Block_Template {

    public function __construct() {
        parent::__construct();
        $this->setTemplate('simi/connector/key/key.phtml');
    }

    public function getKey() {
        $websiteId = Mage::getBlockSingleton('connector/adminhtml_web_switcher')->getWebsiteId();
        $keyItem = Mage::getModel('connector/key')->getKey($websiteId);
        return $keyItem->getKeySecret();
    }

}
