<?php

class Simi_Simipromoteapp_Block_Adminhtml_Simipromoteapp extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct(){
		$this->_controller = 'adminhtml_simipromoteapp';
		$this->_blockGroup = 'simipromoteapp';
		$this->_headerText = Mage::helper('simipromoteapp')->__('Email Report Manager');
		$this->_addButtonLabel = Mage::helper('simipromoteapp')->__('Add Item');
		parent::__construct();
		$this->_removeButton('add');
	}
}