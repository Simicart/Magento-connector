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
class Simi_Connector_Model_Config_Source_ProductsViewType
{
    const LIST_TYPE = 0;
    const GRID_TYPE = 1;

    public function toOptionArray()
    {
        return array(
            self::LIST_TYPE => Mage::helper('connector')->__('List'),
            self::GRID_TYPE => Mage::helper('connector')->__('Grid'),
        );
    }
}