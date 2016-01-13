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
 * Siminotification Model
 * 
 * @category 	Magestore
 * @package 	Magestore_Siminotification
 * @author  	Magestore Developer
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