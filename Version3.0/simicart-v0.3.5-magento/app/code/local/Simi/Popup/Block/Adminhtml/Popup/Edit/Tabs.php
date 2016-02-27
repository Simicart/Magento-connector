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
 * Popup Edit Tabs Block
 * 
 * @category    
 * @package     Popup
 * @author      Developer
 */
class Simi_Popup_Block_Adminhtml_Popup_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('popup_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('popup')->__('Popup Information'));
    }

    /**
     * prepare before render block to html
     *
     * @return Simi_Popup_Block_Adminhtml_Popup_Edit_Tabs
     */
    protected function _beforeToHtml() {
        $this->addTab('form_section', array(
            'label' => Mage::helper('popup')->__('Popup Information'),
            'title' => Mage::helper('popup')->__('Popup Information'),
            'content' => $this->getLayout()->createBlock('popup/adminhtml_popup_edit_tab_form')->toHtml(),
        ));
        return parent::_beforeToHtml();
    }

}