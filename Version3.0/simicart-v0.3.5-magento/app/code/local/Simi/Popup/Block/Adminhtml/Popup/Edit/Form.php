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
 * Popup Edit Form Block
 * 
 * @category    
 * @package     Popup
 * @author      Developer
 */
class Simi_Popup_Block_Adminhtml_Popup_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

    /**
     * prepare form's information for block
     *
     * @return Simi_Popup_Block_Adminhtml_Popup_Edit_Form
     */
    protected function _prepareForm() {
        $form = new Varien_Data_Form(array(
                    'id' => 'edit_form',
                    'action' => $this->getUrl('*/*/save', array(
                        'id' => $this->getRequest()->getParam('id'),
                    )),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data'
                ));

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }

}