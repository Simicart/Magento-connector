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
 * @package 	Magestore_Madapter
 * @copyright 	Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license 	http://www.magestore.com/license-agreement.html
 */

/**
 * Madapter Model
 * 
 * @category 	Magestore
 * @package 	Magestore_Madapter
 * @author  	Magestore Developer
 */
class Simi_Connector_Model_Banner extends Mage_Core_Model_Abstract {

    protected $_website_id = null;

    public function _construct() {
        parent::_construct();
        $this->_init('connector/banner');
    }

    public function getBannerList() {
        $website_id = Mage::app()->getStore()->getWebsiteId();
        $list = array();
        $collection = $this->getCollection()
                ->addFieldToFilter('status', 1)
                ->addFieldToFilter('website_id',array('in' => array($website_id, 0)));
        
        foreach ($collection as $item) {
            $path = Mage::getBaseUrl('media') . 'simi/simicart/banner' . '/' . $item->getWebsiteId() .'/'. $item->getBannerName();
            $categoryName = '';
            $categoryChildrenCount = '';
            if($item->getCategoryId()){
                $category = Mage::getModel('catalog/category')->load($item->getCategoryId());
                $categoryName = $category->getName();
                $categoryChildrenCount = $category->getChildrenCount();
                if($categoryChildrenCount > 0)
                    $categoryChildrenCount = 1;
                else
                    $categoryChildrenCount = 0;
            }
            $list[] = array(
                'image_path' => $path,
                'url' => $item->getBannerUrl(),
                'type' => $item->getType(),
                'categoryID' => $item->getCategoryId(),
                'categoryName' => $categoryName,
                'productID' => $item->getProductId(),
                'has_child' => $categoryChildrenCount,
            );
        }
        return $list;
    }

    public function toOptionArray(){
        $platform = array(
                        '1' => Mage::helper('connector')->__('Product In-app'), 
                        '2' => Mage::helper('connector')->__('Category In-app'), 
                        '3' => Mage::helper('connector')->__('Website Page'), 
                    );
        return $platform;
    }

}