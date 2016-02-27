<?php

/**
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    
 * @package     Popup
 * @copyright   Copyright (c) 2012 
 * @license    
 */

/**
 * Popup Adminhtml Block
 * 
 * @category 	
 * @package 	Popup
 * @author  	Developer
 */
class Simi_Popup_Block_Adminhtml_Popup extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct(){
		$this->_controller = 'adminhtml_popup';
		$this->_blockGroup = 'popup';
		$this->_headerText = Mage::helper('popup')->__('Item Manager');
		$this->_addButtonLabel = Mage::helper('popup')->__('Add Item');
		parent::__construct();
	}
}