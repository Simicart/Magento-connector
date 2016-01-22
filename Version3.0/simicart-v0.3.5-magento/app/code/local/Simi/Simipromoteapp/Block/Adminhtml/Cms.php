<?php

class Simi_Simipromoteapp_Block_Adminhtml_Cms extends Mage_Adminhtml_Block_System_Config_Form_Field
{
	protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
    	$cmsId = Mage::helper('simipromoteapp')->getConfig(Simi_Simipromoteapp_Helper_Email::XML_CMS_PROMOTE_ID);
    	$cms = Mage::getModel('cms/page')->load($cmsId);

    	if($cms->getId()){
			$frontend_link = Mage::getUrl($cms->getData('identifier'));
			$backend_link = Mage::helper("adminhtml")->getUrl('adminhtml/cms_page/edit',array('page_id'=>$cms->getId(),'_query' => array('active_tab' => 'content_section')));
	    	return '<a href="'.$backend_link.'" target="_blank" title="Promote App">CMS In Backend</a> | <a href="'.$frontend_link.'" target="_blank" title="Promote App">CMS In Frontend</a>';
    	} else {
    		return '';
    	}
    }

}