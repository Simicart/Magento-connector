<?php

class Simi_Simipromoteapp_Block_Adminhtml_Simipromoteapp_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct(){
		parent::__construct();
		$this->setId('simipromoteapp_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('simipromoteapp')->__('Item Information'));
	}

	protected function _beforeToHtml(){
		$this->addTab('form_section', array(
			'label'	 => Mage::helper('simipromoteapp')->__('Item Information'),
			'title'	 => Mage::helper('simipromoteapp')->__('Item Information'),
			'content'	 => $this->getLayout()->createBlock('simipromoteapp/adminhtml_simipromoteapp_edit_tab_form')->toHtml(),
		));
		return parent::_beforeToHtml();
	}
}