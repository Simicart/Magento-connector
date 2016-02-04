<?php

/**
 * Created by PhpStorm.
 * User: taynv_000
 * Date: 10/21/2015
 * Time: 9:22 AM
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