<?php
/**
 *
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category 	
 * @package 	Similayerednavigation
 * @copyright 	Copyright (c) 2012 
 * @license 	
 */

/**
 * Layerednavigation Model
 * 
 * @category    
 * @package     Similayerednavigation
 * @author      Developer
 */
class Simi_Similayerednavigation_Model_Layerednavigation extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('similayerednavigation/layerednavigation');
    }
}