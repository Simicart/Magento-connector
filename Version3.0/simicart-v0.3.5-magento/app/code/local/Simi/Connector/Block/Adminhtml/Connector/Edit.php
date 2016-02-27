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
 * Connector Edit Block
 * 
 * @category    
 * @package     Connector
 * @author      Developer
 */
class Simi_Connector_Block_Adminhtml_Connector_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'connector';
        $this->_controller = 'adminhtml_connector';
        $this->_updateButton('save', 'label', Mage::helper('connector')->__('Save'));
        //$this->_updateButton('delete', 'label', Mage::helper('connector')->__('Delete Item'));
        $this->removeButton('delete');
        $this->removeButton('reset');
        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
                ), -100);

        $this->_formScripts[] = "
			function toggleEditor() {
				if (tinyMCE.getInstanceById('connector_content') == null)
					tinyMCE.execCommand('mceAddControl', false, 'connector_content');
				else
					tinyMCE.execCommand('mceRemoveControl', false, 'connector_content');
			}

			function saveAndContinueEdit(){
				editForm.submit($('edit_form').action+'back/edit/');
			}
		";
    }

    protected function _prepareLayout() {
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->getLayout()->getBlock('head')->addJs('jscolor/jscolor.js');
        $this->getLayout()->getBlock('head')->addJs('scriptaculous/scriptaculous.js');
        return parent::_prepareLayout();
    }

    /**
     * get text to show in header when edit an item
     *
     * @return string
     */
    public function getHeaderText() {
        $device_id = $this->getRequest()->getParam('device_id');
        $device_name = Mage::helper('connector')->getNameDeviceById($device_id);
        return Mage::helper('connector')->__("Edit app on device '%s'", $device_name);
    }

}