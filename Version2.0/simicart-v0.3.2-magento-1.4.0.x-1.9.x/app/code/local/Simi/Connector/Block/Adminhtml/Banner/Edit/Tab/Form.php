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
 * @package 	Magestore_Madapter
 * @copyright 	Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license 	http://www.magestore.com/license-agreement.html
 */

/**
 * Simi Edit Form Content Tab Block
 * 
 * @category 	Magestore
 * @package 	Magestore_Madapter
 * @author  	Magestore Developer
 */
class Simi_Connector_Block_Adminhtml_Banner_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    /**
     * prepare tab form's information
     *
     * @return Simi_Connector_Block_Adminhtml_Banner_Edit_Tab_Form
     */
    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        if (Mage::getSingleton('adminhtml/session')->getConnectorData()) {
            $data = Mage::getSingleton('adminhtml/session')->getConnectorData();
            Mage::getSingleton('adminhtml/session')->setConnectorData(null);
        } elseif (Mage::registry('banner_data'))
            $data = Mage::registry('banner_data')->getData();

        $fieldset = $form->addFieldset('connector_form', array('legend' => Mage::helper('connector')->__('Banner information')));

        $fieldset->addField('website_id', 'select', array(
            'label' => Mage::helper('connector')->__('Choose website'),
            'name' => 'website_id',
            'values' => Mage::getSingleton('connector/status')->getWebsite(),
        ));


        $fieldset->addField('banner_title', 'text', array(
            'label' => Mage::helper('connector')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'banner_title',
        ));

        if (isset($data['banner_name']) && $data['banner_name']) {

            $data['banner_name'] = Mage::getBaseUrl('media') . 'simi/simicart/banner/' . $data['website_id'] . '/' . $data['banner_name'];
        }
        $fieldset->addField('banner_name', 'image', array(
            'label' => Mage::helper('connector')->__('Image (width:640px, height:180px)'),
            'required' => FALSE,
            'name' => 'banner_name_co',
        ));

        $fieldset->addField('type', 'select', array(
            'label' => Mage::helper('connector')->__('Direct viewers to'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'type',
            'values' => Mage::getModel('connector/banner')->toOptionArray(),
            'onchange' => 'onchangeNoticeType(this.value)',
            'after_element_html' => '<script> Event.observe(window, "load", function(){onchangeNoticeType(\''.$data['type'].'\');});</script>',
        ));

        $productIds = implode(", ", Mage::getResourceModel('catalog/product_collection')->getAllIds());
        $fieldset->addField('product_id', 'text', array(
            'name' => 'product_id',
            'class' => 'required-entry',
            'required' => true,
            'label' => Mage::helper('connector')->__('Product ID'),
            'note'  => Mage::helper('connector')->__('Choose a product'),
            'after_element_html' => '<a id="product_link" href="javascript:void(0)" onclick="toggleMainProducts()"><img src="' . $this->getSkinUrl('images/rule_chooser_trigger.gif') . '" alt="" class="v-middle rule-chooser-trigger" title="Select Products"></a><input type="hidden" value="'.$productIds.'" id="product_all_ids"/><div id="main_products_select" style="display:none;width:640px"></div>
                <script type="text/javascript">
                    function toggleMainProducts(){
                        if($("main_products_select").style.display == "none"){
                            var url = "' . $this->getUrl('connectoradmin/adminhtml_banner/chooserMainProducts') . '";
                            var params = $("product_id").value.split(", ");
                            var parameters = {"form_key": FORM_KEY,"selected[]":params };
                            var request = new Ajax.Request(url,
                            {
                                evalScripts: true,
                                parameters: parameters,
                                onComplete:function(transport){
                                    $("main_products_select").update(transport.responseText);
                                    $("main_products_select").style.display = "block"; 
                                }
                            });
                        }else{
                            $("main_products_select").style.display = "none";
                        }
                    };
                    var grid;
                   
                    function constructData(div){
                        grid = window[div.id+"JsObject"];
                        if(!grid.reloadParams){
                            grid.reloadParams = {};
                            grid.reloadParams["selected[]"] = $("product_id").value.split(", ");
                        }
                    }
                    function toogleCheckAllProduct(el){
                        if(el.checked == true){
                            $$("#main_products_select input[type=checkbox][class=checkbox]").each(function(e){
                                if(e.name != "check_all"){
                                    if(!e.checked){
                                        if($("product_id").value == "")
                                            $("product_id").value = e.value;
                                        else
                                            $("product_id").value = $("product_id").value + ", "+e.value;
                                        e.checked = true;
                                        grid.reloadParams["selected[]"] = $("product_id").value.split(", ");
                                    }
                                }
                            });
                        }else{
                            $$("#main_products_select input[type=checkbox][class=checkbox]").each(function(e){
                                if(e.name != "check_all"){
                                    if(e.checked){
                                        var vl = e.value;
                                        if($("product_id").value.search(vl) == 0){
                                            if($("product_id").value == vl) $("product_id").value = "";
                                            $("product_id").value = $("product_id").value.replace(vl+", ","");
                                        }else{
                                            $("product_id").value = $("product_id").value.replace(", "+ vl,"");
                                        }
                                        e.checked = false;
                                        grid.reloadParams["selected[]"] = $("product_id").value.split(", ");
                                    }
                                }
                            });
                            
                        }
                    }
                    function selectProduct(e) {
                        if(e.checked == true){
                            if(e.id == "main_on"){
                                $("product_id").value = $("product_all_ids").value;
                            }else{
                                if($("product_id").value == "")
                                    $("product_id").value = e.value;
                                else
                                    $("product_id").value = e.value;
                                grid.reloadParams["selected[]"] = $("product_id").value;
                            }
                        }else{
                             if(e.id == "main_on"){
                                $("product_id").value = "";
                            }else{
                                var vl = e.value;
                                if($("product_id").value.search(vl) == 0){
                                    $("product_id").value = $("product_id").value.replace(vl+", ","");
                                }else{
                                    $("product_id").value = $("product_id").value.replace(", "+ vl,"");
                                }
                            }
                        }
                        
                    }
                </script>'
        ));

        $fieldset->addField('category_id', 'text', array(
            'name' => 'category_id',
            'class' => 'required-entry',
            'required' => true,
            'label' => Mage::helper('connector')->__('Category ID'),
            'note'  => Mage::helper('connector')->__('Choose a category'),
            'after_element_html' => '<a id="category_link" href="javascript:void(0)" onclick="toggleMainCategories()"><img src="' . $this->getSkinUrl('images/rule_chooser_trigger.gif') . '" alt="" class="v-middle rule-chooser-trigger" title="Select Category"></a>
                <div id="main_categories_select" style="display:none"></div>
                    <script type="text/javascript">
                    function toggleMainCategories(check){
                        var cate = $("main_categories_select");
                        if($("main_categories_select").style.display == "none" || (check ==1) || (check == 2)){
                            var url = "' . $this->getUrl('connectoradmin/adminhtml_banner/chooserMainCategories') . '";                        
                            if(check == 1){
                                $("category_id").value = $("category_all_ids").value;
                            }else if(check == 2){
                                $("category_id").value = "";
                            }
                            var params = $("category_id").value.split(", ");
                            var parameters = {"form_key": FORM_KEY,"selected[]":params };
                            var request = new Ajax.Request(url,
                                {
                                    evalScripts: true,
                                    parameters: parameters,
                                    onComplete:function(transport){
                                        $("main_categories_select").update(transport.responseText);
                                        $("main_categories_select").style.display = "block"; 
                                    }
                                });
                        if(cate.style.display == "none"){
                            cate.style.display = "";
                        }else{
                            cate.style.display = "none";
                        } 
                    }else{
                        cate.style.display = "none";                    
                    }
                };
        </script>
            '
        ));

        $fieldset->addField('banner_url', 'editor', array(
            'name' => 'banner_url',           
            'label' => Mage::helper('connector')->__('Url'),
            'title' => Mage::helper('connector')->__('Url'),
            'required' => false,
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('connector')->__('Status'),
            'name' => 'status',
            'values' => Mage::getSingleton('connector/status')->getOptionHash(),
        ));

        $form->setValues($data);
        return parent::_prepareForm();
    }

}