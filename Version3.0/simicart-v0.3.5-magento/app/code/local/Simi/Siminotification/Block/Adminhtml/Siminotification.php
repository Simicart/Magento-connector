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
class Simi_Siminotification_Block_Adminhtml_Siminotification extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct(){
		$this->_controller = 'adminhtml_siminotification';
		$this->_blockGroup = 'siminotification';
		$this->_headerText = Mage::helper('siminotification')->__('Notification Manager');
		$this->_addButtonLabel = Mage::helper('siminotification')->__('Add Notification');
		parent::__construct();
	}
}