<?php

class Simi_Siminotification_Block_Adminhtml_Siminotification_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct(){
		parent::__construct();
		$this->setId('siminotification_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('siminotification')->__('Notification Information'));
	}
	
	/**
	 * prepare before render block to html
	 *
	 * @return Simi_Siminotification_Block_Adminhtml_Siminotification_Edit_Tabs
	 */
	protected function _beforeToHtml(){
		$this->addTab('form_section', array(
			'label'	 => Mage::helper('siminotification')->__('Notification Information'),
			'title'	 => Mage::helper('siminotification')->__('Notification Information'),
			'content'	 => $this->getLayout()->createBlock('siminotification/adminhtml_siminotification_edit_tab_form')->toHtml(),
		));
		return parent::_beforeToHtml();
	}
}