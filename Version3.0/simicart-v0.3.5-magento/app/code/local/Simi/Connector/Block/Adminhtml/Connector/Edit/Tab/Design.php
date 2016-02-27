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
 * @package 	Connector
 * @author  	Developer
 */
class Simi_Connector_Block_Adminhtml_Connector_Edit_Tab_Design extends Mage_Adminhtml_Block_Template
    implements Mage_Adminhtml_Block_Widget_Tab_Interface{

    public function __construct() {
        parent::__construct();
        $this->setShowGlobalIcon(true);
        $this->setTemplate('connector/edit/tab/design.phtml');
    }

    public function canShowTab() {
        return false;
    }

    public function getTabLabel() {
        return $this->__('Design');
    }

    public function getTabTitle() {
        return $this->__('Design');
    }

    public function isHidden() {
        return true;
    }

}