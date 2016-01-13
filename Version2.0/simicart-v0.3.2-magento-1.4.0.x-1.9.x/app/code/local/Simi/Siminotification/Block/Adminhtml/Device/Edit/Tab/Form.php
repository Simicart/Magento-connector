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
 * Siminotification Edit Form Content Tab Block
 * 
 * @category 	Magestore
 * @package 	Magestore_Siminotification
 * @author  	Magestore Developer
 */
class Simi_Siminotification_Block_Adminhtml_Device_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	/**
	 * prepare tab form's information
	 *
	 * @return Simi_Siminotification_Block_Adminhtml_Siminotification_Edit_Tab_Form
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
        $this->setForm($form);
        $websites = Mage::helper('siminotification')->getWebsites();
        $list_web = array();
        foreach ($websites as $website) {
            $list_web[] = array(
                'value' => $website->getId(),
                'label' => $website->getName(),
            );
        }

		if (Mage::getSingleton('adminhtml/session')->getDeviceData()){
			$data = Mage::getSingleton('adminhtml/session')->getDeviceData();
			Mage::getSingleton('adminhtml/session')->setDeviceData(null);
		}elseif(Mage::registry('device_data'))
			$data = Mage::registry('device_data')->getData();
		
		$fieldset = $form->addFieldset('device_form', array('legend'=>Mage::helper('siminotification')->__('Device information')));
        $fieldset->addType('datetime', 'Simi_Siminotification_Block_Adminhtml_Device_Edit_Renderer_Datetime');
        $fieldset->addType('selectname', 'Simi_Siminotification_Block_Adminhtml_Device_Edit_Renderer_Selectname');

		$fieldset->addField('website_id', 'select', array(
            'label'    => Mage::helper('siminotification')->__('Website'),
            'name'     => 'website_id',
            'values'   => $list_web,
            'disabled' => true,
        ));

        $fieldset->addField('plaform_id', 'select', array(
            'label'  => Mage::helper('siminotification')->__('Device Type'),
            'name'   => 'plaform_id',
            'values' => array(
                array('value' => 1, 'label' => Mage::helper('siminotification')->__('iPhone')),
                array('value' => 2, 'label' => Mage::helper('siminotification')->__('iPad')),
                array('value' => 3, 'label' => Mage::helper('siminotification')->__('Android')),
            ),
            'disabled' => true,
        ));

        $fieldset->addField('country', 'selectname', array(
            'label' => Mage::helper('siminotification')->__('Country'),
            'bold'  => true,
            'name'  => 'country',

        ));

        $fieldset->addField('state', 'label', array(
            'label' => Mage::helper('siminotification')->__('State/Province'),
            // 'bold'  => true,
        ));       

        $fieldset->addField('city', 'label', array(
            'label' => Mage::helper('siminotification')->__('City'),
            // 'bold'  => true,
        )); 

        $fieldset->addField('device_token', 'label', array(
            'label' => Mage::helper('siminotification')->__('Device Token'),
        )); 

        $fieldset->addField('created_time', 'datetime', array(
            'label' => Mage::helper('siminotification')->__('Create Date'),
            'bold'  => true,
            'name'  => 'created_date',
        )); 

		$form->setValues($data);
		return parent::_prepareForm();
	}
}