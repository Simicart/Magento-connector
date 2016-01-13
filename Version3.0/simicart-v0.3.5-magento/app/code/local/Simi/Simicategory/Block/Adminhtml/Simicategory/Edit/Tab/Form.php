<?php

class Simi_Simicategory_Block_Adminhtml_Simicategory_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$this->setForm($form);

		if (Mage::getSingleton('adminhtml/session')->getSimicategoryData()){
			$data = Mage::getSingleton('adminhtml/session')->getSimicategoryData();
			Mage::getSingleton('adminhtml/session')->setSimicategoryData(null);
		}elseif(Mage::registry('simicategory_data'))
			$data = Mage::registry('simicategory_data')->getData();
		
		$fieldset = $form->addFieldset('simicategory_form', array('legend'=>Mage::helper('simicategory')->__('Item information')));

		 $fieldset->addField('website_id', 'select', array(
            'label' => Mage::helper('connector')->__('Choose website'),
            'name' => 'website_id',
            'values' => Mage::getSingleton('connector/status')->getWebsite(),
        ));

		$fieldset->addField('simicategory_filename', 'image', array(
			'label'		=> Mage::helper('simicategory')->__('Image (width:220px, height:220px)'),
			'required'	=> true,
			'name'		=> 'simicategory_filename',
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
                            var url = "' . $this->getUrl('adminhtml/connector_banner/chooserMainCategories') . '";                        
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

		$fieldset->addField('status', 'select', array(
			'label'		=> Mage::helper('simicategory')->__('Status'),
			'name'		=> 'status',
			'values'	=> Mage::getSingleton('simicategory/status')->getOptionHash(),
		));


		$form->setValues($data);
		return parent::_prepareForm();
	}
}