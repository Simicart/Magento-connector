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
class Simi_Siminotification_Block_Adminhtml_History_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
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
        // $googleApiKey = Mage::helper('siminotification')->getConfig('gkey');
        // $distanceUnit = Mage::helper('siminotification')->getConfig('distance_unit');

        $list_web = array();
        foreach ($websites as $website) {
            $list_web[] = array(
                'value' => $website->getId(),
                'label' => $website->getName(),
            );
        }
		
		if (Mage::getSingleton('adminhtml/session')->getHistoryData()){
			$data = Mage::getSingleton('adminhtml/session')->getHistoryData();
			Mage::getSingleton('adminhtml/session')->setHistoryData(null);
		}elseif(Mage::registry('history_data'))
			$data = Mage::registry('history_data')->getData();
        
		$fieldset = $form->addFieldset('history_data', array('legend'=>Mage::helper('siminotification')->__('Notification Information')));
        $fieldset->addType('datetime', 'Simi_Siminotification_Block_Adminhtml_Device_Edit_Renderer_Datetime');
        $fieldset->addField('website_id', 'select', array(
            'label' => Mage::helper('siminotification')->__('Website'),
            'name' => 'website_id',
            'values' => $list_web,
            'disabled'  => true,
        ));

         $fieldset->addField('show_popup', 'select', array(
            'label' => Mage::helper('siminotification')->__('Show Popup'),
            'name' => 'show_popup',
            'values' => array(
                array('value' => 1, 'label' => Mage::helper('siminotification')->__('Yes')),
                array('value' => 0, 'label' => Mage::helper('siminotification')->__('No')),
            ),
            'disabled'  => true,
        ));

        $fieldset->addField('notice_title', 'label', array(
            'label' => Mage::helper('siminotification')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'notice_title',
            'bold' =>true,
        ));

        $fieldset->addField('image_url', 'image', array(
            'label'        => Mage::helper('siminotification')->__('Image'),
            'name'        => 'image_url',
            'disabled'  => true,
        ));

        $fieldset->addField('notice_content', 'editor', array(
            'name' => 'notice_content',
            // 'class' => 'required-entry',
            // 'required' => true,
            'label' => Mage::helper('siminotification')->__('Message'),
            'title' => Mage::helper('siminotification')->__('Message'),
            'note'  => Mage::helper('siminotification')->__('characters max: 250'),
            'readonly' => true,
        ));

        $fieldset->addField('type', 'select', array(
            'label' => Mage::helper('siminotification')->__('Direct viewers to'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'type',
            'values' => Mage::getModel('siminotification/siminotification')->toOptionArray(),
            'onchange' => 'onchangeNoticeType(this.value)',
            'after_element_html' => '<script> Event.observe(window, "load", function(){onchangeNoticeType(\''.$data['type'].'\');});</script>',
            'disabled'  => true,
        ));

        $fieldset->addField('product_id', 'text', array(
            'name' => 'product_id',
            'class' => 'required-entry',
            'required' => true,
            'label' => Mage::helper('siminotification')->__('Product ID'),
            'readonly' => true,
        ));

        $fieldset->addField('category_id', 'text', array(
            'name' => 'category_id',
            'class' => 'required-entry',
            'required' => true,            
            'label' => Mage::helper('siminotification')->__('Category ID'),
            'readonly' => true,
        ));

        $fieldset->addField('notice_url', 'text', array(
            'name' => 'notice_url',
            'class' => 'required-entry',
            'required' => true,
            'label' => Mage::helper('siminotification')->__('URL'),
            'readonly' => true,
        ));

        $fieldset->addField('created_time', 'datetime', array(
            'label' => Mage::helper('siminotification')->__('Sent Date'),
            'bold'  => true,
            'name'  => 'created_date',
        ));    

        $fieldsetFilter = $form->addFieldset('filter_form', array(
            'legend'=>Mage::helper('siminotification')->__('Notification Device & Location')
        ));
        $fieldsetFilter->addType('selectname', 'Simi_Siminotification_Block_Adminhtml_Device_Edit_Renderer_Selectname');
        $fieldsetFilter->addField('device_id', 'select', array(
            'label' => Mage::helper('siminotification')->__('Device Type'),
            'name' => 'device_id',
            'values' => array(
                array('value' => 0, 'label' => Mage::helper('siminotification')->__('All')),
                array('value' => 1, 'label' => Mage::helper('siminotification')->__('IOS')),
                array('value' => 2, 'label' => Mage::helper('siminotification')->__('Android')),
            ),
            'onchange' => 'onchangeDevice()',
            'after_element_html' => '<script> 
                                        Event.observe(window, "load", function(){
                                            onchangeDevice();
                                        });
                                    </script>',
            'disabled'  => true,
        ));

        // if($data['device_id'] == 1)
        //     $hidden = true;
        // $fieldsetFilter->addField('notice_sanbox', 'select', array(
        //     'label' => Mage::helper('siminotification')->__('Sandbox mode'),
        //     'name' => 'notice_sanbox',
        //     'values' => array(
        //         array('value' => 0, 'label' => Mage::helper('siminotification')->__('No')),
        //         array('value' => 1, 'label' => Mage::helper('siminotification')->__('Yes')),
        //     ),
        //     'note' => 'used for IOS',
        //     'after_element_html' => ' <script type="text/javascript">                    
        //             function onchangeDevice(){                    
        //                  var check = $(\'device_id\').value;                         
        //                  if(check == 1)                          
        //                    $(\'notice_sanbox\').parentNode.parentNode.show();      
        //                  else
        //                     $(\'notice_sanbox\').parentNode.parentNode.hide();    
        //             }                                               
        //                 </script>',
        //     'disabled'  => true,
        // ));

        // $fieldsetFilter->addField('location', 'text', array(
        //     'name' => 'location',
        //     'label' => Mage::helper('siminotification')->__('Location'),
        // ));

        // $fieldsetFilter->addField('distance', 'text', array(
        //     'name' => 'distance',
        //     'label' => Mage::helper('siminotification')->__('Radius'),
        //     'note' => Mage::helper('siminotification')->__('Measure unit: %s', $distanceUnit),
        // ));

        // if($data['address'])
        $fieldsetFilter->addField('address', 'label', array(
            'name' => 'address',
            'label' => Mage::helper('siminotification')->__('Address'),
        ));

        // if($data['country'])
        $fieldsetFilter->addField('country', 'selectname', array(
            'name' => 'country',
            'label' => Mage::helper('siminotification')->__('Country'),
        ));

        // if($data['state'])
        $fieldsetFilter->addField('state', 'label', array(
            'name' => 'state',
            'label' => Mage::helper('siminotification')->__('State/Province'),
        ));

        // if($data['city'])
        $fieldsetFilter->addField('city', 'label', array(
            'name' => 'city',
            'label' => Mage::helper('siminotification')->__('City'),
        ));

        // if($data['zipcode'])
        $fieldsetFilter->addField('zipcode', 'label', array(
            'name' => 'zipcode',
            'label' => Mage::helper('siminotification')->__('Zip Code'),
        ));

        $form->setValues($data);
        return parent::_prepareForm();
    }
}