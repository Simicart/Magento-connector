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
 * Connector Edit Form Content Tab Block
 * 
 * @category 	
 * @package 	Connector
 * @author  	Developer
 */
class Simi_Connector_Block_Adminhtml_Connector_Edit_Tab_Android extends Mage_Adminhtml_Block_Widget_Form {

    /**
     * prepare tab form's information
     *
     * @return Simi_Connector_Block_Adminhtml_Connector_Edit_Tab_Form
     */
    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $data = array();        
        $data['android_key'] = Mage::getStoreConfig('connector/android_key');
		$data['android_sendid'] = Mage::getStoreConfig('connector/android_sendid');
        $fieldset = $form->addFieldset('connector_android', array('legend' => Mage::helper('connector')->__('Key Notification')));

        $fieldset->addField('android_key', 'password', array(
            'label' => Mage::helper('connector')->__('Google Cloud Messaging API Key'),            
            'name' => 'android_key',
            'note' => 'Key to send Notification Android. <br>You can use SimiCart API Key is AIzaSyAi4qYNCgQ13VPDRtE_GYa0Bw7ZH-Ix5NU'
        ));
		
		$fieldset->addField('android_sendid', 'password', array(
            'label' => Mage::helper('connector')->__('Google Cloud Messaging Sender ID'),            
            'name' => 'android_sendid',
            'note' => 'Id to send Notification Android. <br>You can use SimiCart Sender ID is 518903118242'
        ));
        $form->setValues($data);
        return parent::_prepareForm();
    }

}