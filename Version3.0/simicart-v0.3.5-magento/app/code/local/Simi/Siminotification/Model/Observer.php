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
 * @category    Magestore
 * @package     Magestore_Siminotification
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

 /**
 * Siminotification Observer Model
 * 
 * @category    Magestore
 * @package     Magestore_Siminotification
 * @author      Magestore Developer
 */
class Simi_Siminotification_Model_Observer
{
    /**
     * process catalog_product_save_after event
     *
     * @return Simi_Siminotification_Model_Observer
     */
    public function sendNotificationProductChangePrice($observer){
        $helper = Mage::helper('siminotification');
        if($helper->getConfig('noti_price_enable')){
            $newProduct = $observer->getProduct();
            $newPrice = $newProduct->getData('price');
            $newSpecialPrice = $newProduct->getData('special_price');
            $oldProduct = Mage::getModel('catalog/product')->load($newProduct->getId());
            $oldPrice = $oldProduct->getData('price');
            $oldSpecialPrice = $oldProduct->getData('special_price');
            if ($oldSpecialPrice != $newSpecialPrice && $newProduct->getId() > 0
                && $newProduct->getStatus() == '1' && $newProduct->getVisibility() != '1'){              
                $data = array();
                $content = Mage::helper('siminotification')->__(
                                        $helper->getConfig('noti_price_message'), 
                                        $newProduct->getName(), 
                                        $this->formatPrice($oldSpecialPrice), 
                                        $this->formatPrice($newSpecialPrice));
                $data['website_id'] = $helper->getConfig('noti_price_website');
                $data['show_popup'] = $helper->getConfig('noti_price_showpopup');
                $data['notice_title'] = $helper->getConfig('noti_price_title');
                $data['notice_url'] = $helper->getConfig('noti_price_url');
                $data['notice_content'] = $content;
                $data['device_id'] = $helper->getConfig('noti_price_platform');
                $data['notice_sanbox'] = $helper->getConfig('noti_price_sandbox');
                $data['type'] = $helper->getConfig('noti_price_type');
                $data['product_id'] = $newProduct->getId();
                $data['category_id'] = $helper->getConfig('noti_price_category_id');
                $data['category_name'] = $this->getCategoryName($helper->getConfig('noti_price_category_id'));
                $data['has_child'] = $this->getCategoryChildrenCount($helper->getConfig('noti_price_category_id'));
                $data['created_time'] = now();
                $data['notice_type'] = 1;
                $resultSend = Mage::helper('siminotification')->sendNotice($data);
            }elseif ($oldPrice != $newPrice && $newProduct->getId() > 0
                && $newProduct->getStatus() == '1' && $newProduct->getVisibility() != '1'){                
                $data = array();
                $content = Mage::helper('siminotification')->__(
                                        $helper->getConfig('noti_price_message'), 
                                        $newProduct->getName(), 
                                        $this->formatPrice($oldPrice), 
                                        $this->formatPrice($newPrice));
                $data['website_id'] = $helper->getConfig('noti_price_website');
                $data['show_popup'] = $helper->getConfig('noti_price_showpopup');
                $data['notice_title'] = $helper->getConfig('noti_price_title');
                $data['notice_url'] = $helper->getConfig('noti_price_url');
                $data['notice_content'] = $content;
                $data['device_id'] = $helper->getConfig('noti_price_platform');
                $data['notice_sanbox'] = $helper->getConfig('noti_price_sandbox');
                $data['type'] = $helper->getConfig('noti_price_type');
                $data['product_id'] = $newProduct->getId();
                $data['category_id'] = $helper->getConfig('noti_price_category_id');
                $data['category_name'] = $this->getCategoryName($helper->getConfig('noti_price_category_id'));
                $data['has_child'] = $this->getCategoryChildrenCount($helper->getConfig('noti_price_category_id'));
                $data['created_time'] = now();
                $data['notice_type'] = 1;
                $resultSend = Mage::helper('siminotification')->sendNotice($data);
            }elseif(!$newProduct->getId()){
                 Mage::getSingleton('core/session')->setData('new_added_product_sku', $newProduct->getSku());
            }
        }
    }

    public function sendNotificationNewProduct($observer){
        $helper = Mage::helper('siminotification');
        if($helper->getConfig('new_product_enable')){
            $newProduct = $observer->getProduct();
            $lastProductId = Mage::getModel('catalog/product')->getCollection()
                                ->setOrder('entity_id','desc')->getFirstItem()->getId();
            if($newProduct->getId() && $newProduct->getId() == $lastProductId 
                && $newProduct->getStatus() == '1' && $newProduct->getVisibility() != '1'
                && $newProduct->getSku() == Mage::getSingleton('core/session')->getData('new_added_product_sku')){
                $content = Mage::helper('siminotification')->__(
                                        $helper->getConfig('new_product_message'), 
                                        $newProduct->getName());
                $data = array();
                $data['website_id'] = $helper->getConfig('new_product_website');
                $data['show_popup'] = $helper->getConfig('new_product_showpopup');
                $data['notice_title'] = $helper->getConfig('new_product_title');
                $data['notice_url'] = $helper->getConfig('new_product_url');
                $data['notice_content'] = $content;                
                $data['device_id'] = $helper->getConfig('new_product_platform');
                $data['notice_sanbox'] = $helper->getConfig('new_product_sandbox');                
                $data['type'] = $helper->getConfig('new_product_type');
                $data['product_id'] = $newProduct->getId();
                $data['category_id'] = $helper->getConfig('new_product_category_id');
                $data['category_name'] = $this->getCategoryName($helper->getConfig('new_product_category_id'));
                $data['has_child'] = $this->getCategoryChildrenCount($helper->getConfig('new_product_category_id'));
                $data['created_time'] = now();
                $data['notice_type'] = 2;
                Mage::getSingleton('core/session')->setData('new_added_product_sku', NULL);
                $resultSend = Mage::helper('siminotification')->sendNotice($data);
            }
        }
    }

    public function addNotificationPurchaseOrder($observer){
        $helper = Mage::helper('siminotification');
        if($helper->getConfig('noti_purchase_enable')){
            $object = $observer->getObject();
            $content = $helper->__($helper->getConfig('noti_purchase_message'), Mage::app()->getWebsite()->getName());
            $data = $object->getCacheData();
            $notification = array();   
            $notification = array();
            // $notification['customer_group'] = $helper->getConfig('noti_purchase_customer_group');
            $notification['show_popup'] = '1';
            $notification['title'] = $helper->getConfig('noti_purchase_title');
            $notification['url'] = $helper->getConfig('noti_purchase_url');
            $notification['message'] = $content;
            $notification['notice_sanbox'] = 0;
            $notification['type'] = $helper->getConfig('noti_purchase_type');
            $notification['productID'] = $helper->getConfig('noti_purchase_product_id');
            $notification['categoryID'] = $helper->getConfig('noti_purchase_category_id');
            $notification['categoryName'] = $this->getCategoryName($helper->getConfig('noti_purchase_category_id'));
            $notification['has_child'] = $this->getCategoryChildrenCount($helper->getConfig('noti_purchase_category_id'));
            $notification['created_time'] = now();
            $data['notice_type'] = 3;
            $data['notification'] = $notification;
            $object->setCacheData($data, "simi_connector");
        }
        return;
    }

    public function getCategoryName($categoryId){
        $category = Mage::getModel('catalog/category')->load($categoryId);                                   
        $categoryName = $category->getName();
        return $categoryName;
    }

    public function getCategoryChildrenCount($categoryId){
        $category = Mage::getModel('catalog/category')->load($categoryId);                                    
        $categoryChildrenCount = $category->getChildrenCount();
        if($categoryChildrenCount > 0)
            $categoryChildrenCount = 1;
        else
            $categoryChildrenCount = 0;
        return $categoryChildrenCount;
    }

    public function formatPrice($price){
        return Mage::helper('core')->currency($price, true, false);
    }
}