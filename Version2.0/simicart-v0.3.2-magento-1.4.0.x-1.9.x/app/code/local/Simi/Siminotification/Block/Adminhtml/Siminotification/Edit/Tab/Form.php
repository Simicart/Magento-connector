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
class Simi_Siminotification_Block_Adminhtml_Siminotification_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
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
		
		if (Mage::getSingleton('adminhtml/session')->getSiminotificationData()){
			$data = Mage::getSingleton('adminhtml/session')->getSiminotificationData();
			Mage::getSingleton('adminhtml/session')->setSiminotificationData(null);
		}elseif(Mage::registry('siminotification_data'))
			$data = Mage::registry('siminotification_data')->getData();
        
		$fieldset = $form->addFieldset('siminotification_form', array('legend'=>Mage::helper('siminotification')->__('Notification Content')));
        $fieldset->addType('datetime', 'Simi_Siminotification_Block_Adminhtml_Device_Edit_Renderer_Datetime');
		$fieldset->addField('website_id', 'select', array(
            'label' => Mage::helper('siminotification')->__('Website'),
            'name' => 'website_id',
            'values' => $list_web,
        ));

         $fieldset->addField('show_popup', 'select', array(
            'label' => Mage::helper('siminotification')->__('Show Popup'),
            'name' => 'show_popup',
            'values' => array(
                array('value' => 1, 'label' => Mage::helper('siminotification')->__('Yes')),
                array('value' => 0, 'label' => Mage::helper('siminotification')->__('No')),
            ),
            'note' => 'If you choose Yes, there will be a popup shown on mobile screen when notification comes',
        ));

        $fieldset->addField('notice_title', 'text', array(
            'label' => Mage::helper('siminotification')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'notice_title',
        ));

        $fieldset->addField('image_url', 'image', array(
            'label'        => Mage::helper('siminotification')->__('Image'),
            'name'        => 'image_url',
            'note'  => Mage::helper('siminotification')->__('Size max: 1000 x 1000 (PX)'),
        ));

        $fieldset->addField('notice_content', 'editor', array(
            'name' => 'notice_content',
            // 'class' => 'required-entry',
            // 'required' => true,
            'label' => Mage::helper('siminotification')->__('Message'),
            'title' => Mage::helper('siminotification')->__('Message'),
            'note'  => Mage::helper('siminotification')->__('Characters recommended: < 250'),
        ));

        $fieldset->addField('type', 'select', array(
            'label' => Mage::helper('siminotification')->__('Direct viewers to'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'type',
            'values' => Mage::getModel('siminotification/siminotification')->toOptionArray(),
            'onchange' => 'onchangeNoticeType(this.value)',
            'after_element_html' => '<script> Event.observe(window, "load", function(){onchangeNoticeType(\''.$data['type'].'\');});</script>',
        ));

        $productIds = implode(", ", Mage::getResourceModel('catalog/product_collection')->getAllIds());
        $fieldset->addField('product_id', 'text', array(
            'name' => 'product_id',
            'class' => 'required-entry',
            'required' => true,
            'label' => Mage::helper('siminotification')->__('Product ID'),
            'note'  => Mage::helper('siminotification')->__('Choose a product'),
            'after_element_html' => '<a id="product_link" href="javascript:void(0)" onclick="toggleMainProducts()"><img src="' . $this->getSkinUrl('images/rule_chooser_trigger.gif') . '" alt="" class="v-middle rule-chooser-trigger" title="Select Products"></a><input type="hidden" value="'.$productIds.'" id="product_all_ids"/><div id="main_products_select" style="display:none;width:640px"></div>
                <script type="text/javascript">
                    function toggleMainProducts(){
                        if($("main_products_select").style.display == "none"){
                            var url = "' . $this->getUrl('siminotificationadmin/adminhtml_siminotification/chooserMainProducts') . '";
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
            'label' => Mage::helper('siminotification')->__('Category ID'),
            'note'  => Mage::helper('siminotification')->__('Choose a category'),
            'after_element_html' => '<a id="category_link" href="javascript:void(0)" onclick="toggleMainCategories()"><img src="' . $this->getSkinUrl('images/rule_chooser_trigger.gif') . '" alt="" class="v-middle rule-chooser-trigger" title="Select Category"></a>
                <div id="main_categories_select" style="display:none"></div>
                    <script type="text/javascript">
                    function toggleMainCategories(check){
                        var cate = $("main_categories_select");
                        if($("main_categories_select").style.display == "none" || (check ==1) || (check == 2)){
                            var url = "' . $this->getUrl('siminotificationadmin/adminhtml_siminotification/chooserMainCategories') . '";                        
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

        $fieldset->addField('notice_url', 'text', array(
            'name' => 'notice_url',
            'class' => 'required-entry',
            'required' => true,
            'label' => Mage::helper('siminotification')->__('URL'),
        ));

        $fieldset->addField('created_time', 'datetime', array(
            'label' => Mage::helper('siminotification')->__('Created Date'),
            'bold'  => true,
            'name'  => 'created_date',
        ));    

        $fieldsetFilter = $form->addFieldset('filter_form', array(
            'legend'=>Mage::helper('siminotification')->__('Notification Device & Location')
        ));

        $fieldsetFilter->addField('device_id', 'select', array(
            'label' => Mage::helper('siminotification')->__('Device Type'),
            'name' => 'device_id',
            'values' => array(
                array('value' => 0, 'label' => Mage::helper('siminotification')->__('All')),
                array('value' => 1, 'label' => Mage::helper('siminotification')->__('IOS')),
                array('value' => 2, 'label' => Mage::helper('siminotification')->__('Android')),
            ),
            // 'onchange' => 'onchangeDevice()',
            // 'after_element_html' => '<script> 
            //                             Event.observe(window, "load", function(){
            //                                 onchangeDevice();
            //                             });
            //                         </script>',
            // 'after_element_html' => '<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3.17&key='.$googleApiKey.'&sensor=false&libraries=geometry,places"></script>'
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

        $fieldsetFilter->addField('address', 'text', array(
            'name' => 'address',
            'label' => Mage::helper('siminotification')->__('Address'),
        ));

        $fieldsetFilter->addField('country', 'select', array(
            'name' => 'country',
            'label' => Mage::helper('siminotification')->__('Country'),
            'values' => Mage::helper('siminotification')->getOptionCountry(),
        ));

        $fieldsetFilter->addField('state', 'text', array(
            'name' => 'state',
            'label' => Mage::helper('siminotification')->__('State/Province'),
        ));

        $fieldsetFilter->addField('city', 'text', array(
            'name' => 'city',
            'label' => Mage::helper('siminotification')->__('City'),
        ));

        $fieldsetFilter->addField('zipcode', 'text', array(
            'name' => 'zipcode',
            'label' => Mage::helper('siminotification')->__('Zip Code'),
        ));

		$form->setValues($data);
		return parent::_prepareForm();
	}
}