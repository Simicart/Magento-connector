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
 * Connector Edit Tabs Block
 * 
 * @category    
 * @package     Connector
 * @author      Developer
 */
class Simi_Connector_Block_Adminhtml_Connector_Edit_Tab_Notice extends Mage_Adminhtml_Block_Widget_Form {

    public function __construct() {
        parent::__construct();
        $this->setTemplate('connector/edit/tab/notice.phtml');
    }

    public function _prepareLayout() {
        parent::_prepareLayout();
    }
    
    public function getDataNotice(){        
        $device_id = $this->getRequest()->getParam('device_id');
        $web_id = $this->getRequest()->getParam('website');
        return Mage::getModel('connector/notice')->getDataNotice($device_id, $web_id);
    }
    
    public function getWebId(){        
        return $this->getRequest()->getParam('website');
    }
    
    public function getDeviceId(){
        return $this->getRequest()->getParam('device_id');
    }
}