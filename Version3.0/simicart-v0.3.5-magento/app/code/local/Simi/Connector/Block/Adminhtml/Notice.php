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
class Simi_Connector_Block_Adminhtml_Notice extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_controller = 'adminhtml_notice';
        $this->_blockGroup = 'connector';
        $this->_headerText = Mage::helper('connector')->__('Notification Manager');
        $this->_addButtonLabel = Mage::helper('connector')->__('Add Message');
        parent::__construct();
    }

}