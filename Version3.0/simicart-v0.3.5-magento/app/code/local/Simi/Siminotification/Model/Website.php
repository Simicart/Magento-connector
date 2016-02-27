<?php
/**
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    
 * @package     Siminotification
 * @copyright   Copyright (c) 2012 
 * @license     
 */

 /**
 * Siminotification Model
 * 
 * @category    
 * @package     Siminotification
 * @author      Developer
 */
class Simi_Siminotification_Model_Website extends Mage_Core_Model_Abstract
{
	public function _construct(){
		parent::_construct();
		$this->_init('siminotification/website');
	}

	public function toOptionArray(){
		$websites = Mage::helper('siminotification')->getWebsites();
        $listWeb = array();
        foreach ($websites as $website) {
            $listWeb[] = array(
                'value' => $website->getId(),
                'label' => $website->getName(),
            );
        }
		return $listWeb;
	}
}