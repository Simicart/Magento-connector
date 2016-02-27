<?php
/**
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    
 * @package     Siminotification
 * @copyright   Copyright (c) 2012 
 * @license     
 */

 /**
 * Siminotification Adminhtml Block
 * 
 * @category    
 * @package     Siminotification
 * @author      Developer
 */
class Simi_Siminotification_Block_Adminhtml_Device extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct(){
		$this->_controller = 'adminhtml_device';
		$this->_blockGroup = 'siminotification';
		$this->_headerText = Mage::helper('siminotification')->__('Device Manager');
		// $this->_addButtonLabel = Mage::helper('siminotification')->__('Add Device');
		parent::__construct();
		$this->removeButton('add');
	}
}