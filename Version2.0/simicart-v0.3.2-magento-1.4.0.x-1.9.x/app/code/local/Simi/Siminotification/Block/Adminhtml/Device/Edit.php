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
 * Siminotification Edit Block
 * 
 * @category 	Magestore
 * @package 	Magestore_Siminotification
 * @author  	Magestore Developer
 */
class Simi_Siminotification_Block_Adminhtml_Device_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct(){
		parent::__construct();
		
		$this->_objectId = 'id';
		$this->_blockGroup = 'siminotification';
		$this->_controller = 'adminhtml_device';
		
        $this->removeButton('reset');
        $this->removeButton('save');
        $this->_formScripts[] = "
			function toggleEditor() {
				if (tinyMCE.getInstanceById('device_content') == null)
					tinyMCE.execCommand('mceAddControl', false, 'device_content');
				else
					tinyMCE.execCommand('mceRemoveControl', false, 'device_content');
			}

			function saveAndContinueEdit(){
				editForm.submit($('edit_form').action+'back/edit/');
			}
		";
	}
	
	/**
	 * get text to show in header when edit an device
	 *
	 * @return string
	 */
	public function getHeaderText(){
		if(Mage::registry('device_data') && Mage::registry('device_data')->getId())
			return Mage::helper('siminotification')->__("View Device '%s'", $this->htmlEscape(Mage::registry('device_data')->getId()));
		return Mage::helper('siminotification')->__('Add Device');
	}
}