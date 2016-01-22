<?php

class Simi_Simipromoteapp_Block_Adminhtml_Simipromoteapp_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$this->setForm($form);
		
		if (Mage::getSingleton('adminhtml/session')->getSimipromoteappData()){
			$data = Mage::getSingleton('adminhtml/session')->getSimipromoteappData();
			Mage::getSingleton('adminhtml/session')->setSimipromoteappData(null);
		}elseif(Mage::registry('simipromoteapp_data'))
			$data = Mage::registry('simipromoteapp_data')->getData();
		
		$fieldset = $form->addFieldset('simipromoteapp_form', array('legend'=>Mage::helper('simipromoteapp')->__('Item information')));

		$fieldset->addField('title', 'text', array(
			'label'		=> Mage::helper('simipromoteapp')->__('Title'),
			'class'		=> 'required-entry',
			'required'	=> true,
			'name'		=> 'title',
		));

		$fieldset->addField('filename', 'file', array(
			'label'		=> Mage::helper('simipromoteapp')->__('File'),
			'required'	=> false,
			'name'		=> 'filename',
		));

		$fieldset->addField('status', 'select', array(
			'label'		=> Mage::helper('simipromoteapp')->__('Status'),
			'name'		=> 'status',
			'values'	=> Mage::getSingleton('simipromoteapp/status')->getOptionHash(),
		));

		$fieldset->addField('content', 'editor', array(
			'name'		=> 'content',
			'label'		=> Mage::helper('simipromoteapp')->__('Content'),
			'title'		=> Mage::helper('simipromoteapp')->__('Content'),
			'style'		=> 'width:700px; height:500px;',
			'wysiwyg'	=> false,
			'required'	=> true,
		));

		$form->setValues($data);
		return parent::_prepareForm();
	}
}