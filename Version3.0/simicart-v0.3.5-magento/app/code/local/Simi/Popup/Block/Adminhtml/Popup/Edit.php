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
 * Popup Edit Block
 * 
 * @category    
 * @package     Popup
 * @author      Developer
 */
class Simi_Popup_Block_Adminhtml_Popup_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'popup';
        $this->_controller = 'adminhtml_popup';
        $this->removeButton('delete');
        $this->removeButton('reset');
        $this->removeButton('save');
        $this->removeButton('back');
        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
                ), -100);

        $this->_formScripts[] = "
			function toggleEditor() {
				if (tinyMCE.getInstanceById('popup_content') == null)
					tinyMCE.execCommand('mceAddControl', false, 'popup_content');
				else
					tinyMCE.execCommand('mceRemoveControl', false, 'popup_content');
			}

			function saveAndContinueEdit(){
				editForm.submit($('edit_form').action+'back/edit/');
			}
		";
    }

    /**
     * get text to show in header when edit an item
     *
     * @return string
     */
    public function getHeaderText() {
        if (Mage::registry('popup_data') && Mage::registry('popup_data')->getId())
            return Mage::helper('popup')->__("Edit information to show popup on mobile");
        return Mage::helper('popup')->__('Add Item');
    }

}