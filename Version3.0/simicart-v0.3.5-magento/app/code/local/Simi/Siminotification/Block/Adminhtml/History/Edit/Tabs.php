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
 * Siminotification Edit Tabs Block
 * 
 * @category    
 * @package     Siminotification
 * @author      Developer
 */
class Simi_Siminotification_Block_Adminhtml_History_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct(){
		parent::__construct();
		$this->setId('history_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('siminotification')->__('History Information'));
	}
	
	/**
	 * prepare before render block to html
	 *
	 * @return Simi_Siminotification_Block_Adminhtml_Siminotification_Edit_Tabs
	 */
	protected function _beforeToHtml(){
		$this->addTab('form_section', array(
			'label'	 => Mage::helper('siminotification')->__('History Information'),
			'title'	 => Mage::helper('siminotification')->__('History Information'),
			'content'	 => $this->getLayout()->createBlock('siminotification/adminhtml_history_edit_tab_form')->toHtml(),
		));
		return parent::_beforeToHtml();
	}
}