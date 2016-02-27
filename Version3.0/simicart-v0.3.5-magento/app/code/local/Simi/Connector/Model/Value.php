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
 * Connector Model
 * 
 * @category    
 * @package     Connector
 * @author      Developer
 */
class Simi_Connector_Model_Value extends Mage_Core_Model_Abstract
{
	public function _construct(){
		parent::_construct();
        $this->_init('connector/value');
    }

     public function loadAttributeValue($bannerId, $websiteId, $attributeCode ) {
        $attributeValue = $this->getCollection()
                ->addFieldToFilter('banner_id', $bannerId)
                ->addFieldToFilter('website_id', $websiteId)
                ->addFieldToFilter('attribute_code', $attributeCode)
                ->getFirstItem();
        $this->setData('banner_id', $bannerId)
                ->setData('website_id', $websiteId)
                ->setData('attribute_code', $attributeCode);
        if ($attributeValue)
            $this->addData($attributeValue->getData())
                    ->setId($attributeValue->getId());
        return $this;
    }

}