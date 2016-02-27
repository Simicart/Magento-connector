<?php
/**
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category 	
 * @package 	Connector
 * @copyright 	Copyright (c) 2012 
 * @license 	
 */

 /**
 * Connector Edit Tabs Block
 * 
 * @category 	
 * @package 	Connector
 * @author  	Developer
 */
class Simi_Connector_Block_Adminhtml_Cms_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct(){
		parent::__construct();
		$this->setId('notice_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('connector')->__('Block Information'));
	}
	
	/**
	 * prepare before render block to html
	 *
	 * @return Magestore_Madapter_Block_Adminhtml_Madapter_Edit_Tabs
	 */
	protected function _beforeToHtml(){
		$this->addTab('form_section', array(
			'label'	 => Mage::helper('connector')->__('Block Information'),
			'title'	 => Mage::helper('connector')->__('Block Information'),
			'content'	 => $this->getLayout()->createBlock('connector/adminhtml_cms_edit_tab_form')->toHtml(),
		));
		return parent::_beforeToHtml();
	}
}