<?php
/**
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    
 * @package     Appreport
 * @copyright   Copyright (c) 2012 
 * @license     
 */

/**
 * Appreport Model
 * 
 * @category    
 * @package     Appreport
 * @author      Developer
 */
class Simi_Appreport_Model_Appreport extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('appreport/appreport');
    }
}