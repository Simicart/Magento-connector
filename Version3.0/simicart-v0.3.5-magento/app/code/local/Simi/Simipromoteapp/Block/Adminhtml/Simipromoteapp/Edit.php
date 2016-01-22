<?php

class Simi_Simipromoteapp_Block_Adminhtml_Simipromoteapp_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct(){
		parent::__construct();
		
		$this->_objectId = 'id';
		$this->_blockGroup = 'simipromoteapp';
		$this->_controller = 'adminhtml_simipromoteapp';
		
		$this->_updateButton('save', 'label', Mage::helper('simipromoteapp')->__('Save Item'));
		$this->_updateButton('delete', 'label', Mage::helper('simipromoteapp')->__('Delete Item'));
		
		$this->_addButton('saveandcontinue', array(
			'label'		=> Mage::helper('adminhtml')->__('Save And Continue Edit'),
			'onclick'	=> 'saveAndContinueEdit()',
			'class'		=> 'save',
		), -100);

		$this->_formScripts[] = "
			function toggleEditor() {
				if (tinyMCE.getInstanceById('simipromoteapp_content') == null)
					tinyMCE.execCommand('mceAddControl', false, 'simipromoteapp_content');
				else
					tinyMCE.execCommand('mceRemoveControl', false, 'simipromoteapp_content');
			}

			function saveAndContinueEdit(){
				editForm.submit($('edit_form').action+'back/edit/');
			}
		";
	}

	public function getHeaderText(){
		if(Mage::registry('simipromoteapp_data') && Mage::registry('simipromoteapp_data')->getId())
			return Mage::helper('simipromoteapp')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('simipromoteapp_data')->getTitle()));
		return Mage::helper('simipromoteapp')->__('Add Item');
	}
}