<?php
/**
 * Magestore
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category 	Magestore
 * @package 	Magestore_Siminotification
 * @copyright 	Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license 	http://www.magestore.com/license-agreement.html
 */

 /**
 * Siminotification Edit Tabs Block
 * 
 * @category 	Magestore
 * @package 	Magestore_Siminotification
 * @author  	Magestore Developer
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