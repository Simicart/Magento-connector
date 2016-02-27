<?php
/**
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    
 * @package     Connector
 * @copyright   Copyright (c) 2012 
 * @license     
 */

/**
 * Connector Edit Tabs Block
 * 
 * @category    
 * @package     Connector
 * @author      Developer
 */
class Simi_Connector_Block_Adminhtml_Connector_Edit_Tab_Pem extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $id = $this->getRequest()->getParam('id');        
        $pem_dir = Mage::helper('connector')->getDirPEMfile();
        $fieldset = $form->addFieldset('pem_form', array('legend' => Mage::helper('connector')->__('Upload PEM file')));
        $data = array();
        $data['pem_file'] = null;
        if (file_exists($pem_dir)) {
            $data['pem_file'] = Mage::helper('connector')->getPEMfile();
            $fieldset->addField('pem_file', 'file', array(
                'label' => Mage::helper('connector')->__('Upload PEM file'),
                'required' => false,
                'name' => 'pem_file',
                'note' => 'PEM file has been uploaded . It use to send notification to IOS'
            ));
        } else {
            $fieldset->addField('pem_file', 'file', array(
                'label' => Mage::helper('connector')->__('Upload PEM file'),
                'required' => false,
                'name' => 'pem_file',
                'note' => 'You must upload PEM file to send notification to IOS'
            ));
        }


        $form->setValues($data);
        return parent::_prepareForm();
    }

}