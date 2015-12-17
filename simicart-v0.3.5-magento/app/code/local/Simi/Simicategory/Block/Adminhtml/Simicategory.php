<?php

class Simi_Simicategory_Block_Adminhtml_Simicategory extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct(){
		$this->_controller = 'adminhtml_simicategory';
		$this->_blockGroup = 'simicategory';
		$this->_headerText = Mage::helper('simicategory')->__('Category Manager');
		$this->_addButtonLabel = Mage::helper('simicategory')->__('Add Category');
		parent::__construct();
	}
}