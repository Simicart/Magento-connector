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
 * Siminotification Helper
 * 
 * @category    Magestore
 * @package     Magestore_Siminotification
 * @author      Magestore Developer
 */
class Simi_Siminotification_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getListCountry() {
        $listCountry = array();

        $collection = Mage::getResourceModel('directory/country_collection')
                ->loadByStore();

        if (count($collection)) {
            foreach ($collection as $item) {
                $listCountry[$item->getId()] = $item->getName();
            }
        }

        return $listCountry;
    }

    public function getWebsites() {
        $websites = Mage::getModel('core/website')->getCollection();
        return $websites;
    }

    public function getOptionCountry() {
        $optionCountry = array();
        $collection = Mage::getResourceModel('directory/country_collection')
                ->loadByStore();

        $optionCountry[] = array('label' => $this->__('All Countries'), 'value' => '0');        
        if (count($collection)) {
            foreach ($collection as $item) {
                $optionCountry[] = array('label' => $item->getName(), 'value' => $item->getId());
            }
        }

        return $optionCountry;
    }

    public function getConfig($nameConfig) {
        return Mage::getStoreConfig('connector/notification/' . $nameConfig, Mage::app()->getStore()->getId());
    }

    public function sendNotice($data) {
        $trans = $this->send($data);
        // update notification history
        $history = Mage::getModel('siminotification/history'); 
        if(!$trans)
            $data['status'] = 0;
        else
            $data['status'] = 1;
        $history->setData($data);
        $history->save();
        return $trans;
    }

    public function send($data) {
        if($data['category_id']){
            $categoryId = $data['category_id'];
            $category = Mage::getModel('catalog/category')->load($categoryId);                                    
            $categoryChildrenCount = $category->getChildrenCount();
            $categoryName = $category->getName();
            $data['category_name'] = $categoryName;
            if($categoryChildrenCount > 0)
                $categoryChildrenCount = 1;
            else
                $categoryChildrenCount = 0;
            $data['has_child'] = $categoryChildrenCount;
            if(!$data['has_child']){
                $data['has_child'] = '';
            }
        }
        if($data['product_id']){
            $productId = $data['product_id'];
            $productName = Mage::getModel('catalog/product')->load($productId)->getName();
            $data['product_name'] = $productName;
        }
        $website = $data['website_id'];
        $collectionDevice = Mage::getModel('connector/device')->getCollection();
        if ($data['country'] != "0") {
            $country_id = trim($data['country']);
            $collectionDevice->addFieldToFilter('country', array('like' => '%' . $data['country'] . '%'));
        }
        if (isset($data['state']) && ($data['state'] != null)) {
            $city = trim($city);
            $collectionDevice->addFieldToFilter('state', array('like' => '%' . $data['state'] . '%'));
        }
        if (isset($data['city']) && ($data['city'] != null)) {
            $city = trim($city);
            $collectionDevice->addFieldToFilter('city', array('like' => '%' . $data['city'] . '%'));
        }
        if (isset($data['zipcode']) && ($data['zipcode'] != null)) {
            $city = trim($city);
            $collectionDevice->addFieldToFilter('zipcode', array('like' => '%' . $data['zipcode'] . '%'));
        }
        if ((int) $data['device_id'] != 0) {
            // $collectionDevice->addFieldToFilter('website_id', array('eq' => $website));
            if ((int) $data['device_id'] == 2) {
                //send android
                $collectionDevice->addFieldToFilter('plaform_id', array('eq' => 3));
                return $this->sendAndroid($collectionDevice, $data);
            } else {
                //send IOS
                $collectionDevice->addFieldToFilter('plaform_id', array('neq' => 3));
                return $this->sendIOS($collectionDevice, $data);
            }
        } else {
            //send all
            // $collection = $collectionDevice->addFieldToFilter('website_id', array('eq' => $website));
            $collectionDevice = Mage::getModel('connector/device')->getCollection()
                            ->addFieldToFilter('plaform_id', array('eq' => 3));
            $resultIOS = $this->sendIOS($collection, $data);
            $resultAndroid = $this->sendAndroid($collectionDevice, $data);
            if ($resultIOS || $resultAndroid)
                return true;
            else
                return false;
        }
    }

    public function sendIOS($collectionDevice, $data) {
        $ch = Mage::helper('connector')->getDirPEMfile();
        $dir = Mage::helper('connector')->getDirPEMPassfile();
        $message = $data['notice_content'];
        $body['aps'] = array(
            'alert' => $data['notice_title'],
            'sound' => 'default',
            'badge' => 1,
            'title' => $data['notice_title'],
            'message' => $message,
            'url' => $data['notice_url'],
            'type' => $data['type'],
            'productID' => $data['product_id'],
            'categoryID' => $data['category_id'],
            'categoryName' => $data['category_name'],
            'has_child'  => $data['has_child'],
            'imageUrl'   => $data['image_url'],
            'show_popup'   => $data['show_popup'],
        );
        // Zend_debug::dump($body);die();
        $payload = json_encode($body);
        $totalDevice = 0;
        foreach ($collectionDevice as $item) {
            $ctx = stream_context_create();
            stream_context_set_option($ctx, 'ssl', 'local_cert', $ch);
            if ((int) $data['notice_sanbox'] == 1 && (int) $data['device_id'] == 1) {
                $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
            } else {
             $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
            }
            if (!$fp) {
             Mage::getSingleton('adminhtml/session')->addError("Failed to connect:" . $err . $errstr . PHP_EOL . "(IOS)");
                return;
            }
            $deviceToken = $item->getDeviceToken();
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
            // Send it to the server
            $result = fwrite($fp, $msg, strlen($msg));
            if (!$result) {
                Mage::getSingleton('adminhtml/session')->addError('Message not delivered (IOS)' . PHP_EOL);
                return false;
            }
            fclose($fp);
            $totalDevice++;
        }
        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Message successfully delivered to %s devices (IOS)', $totalDevice));
        return true;
    }

    public function sendAndroid($collectionDevice, $data) {
        $api_key = Mage::getStoreConfig('connector/android_key');
//        $api_key = "AIzaSyALAL5f9FOjn2e9s3WkJJvyTvWN9LAyDTs";
        // please enter the registration id of the device on which you want to send the message
        $registrationIDs = array();
        foreach ($collectionDevice as $item) {
            $registrationIDs[] = $item->getDeviceToken();
        }
        $message = array(
            'message' => $data['notice_content'], 
            'url' => $data['notice_url'], 
            'title' => $data['notice_title'],
            'type' => $data['type'],
            'productID' => $data['product_id'],
            'categoryID' => $data['category_id'],
            'categoryName' => $data['category_name'],
            'has_child'  => $data['has_child'],
            'imageUrl'   => $data['image_url'],
            'show_popup'   => $data['show_popup'],
        );
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $registrationIDs,
            'data' => array("message" => $message),
        );

        $headers = array(
            'Authorization: key=' . $api_key,
            'Content-Type: application/json');
        $result = '';
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);
        } catch (Exception $e) {
            
        }
        $re = json_decode($result);
        if ($re == NULL || $re->success == 0) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Message not delivered (Android)'));
            return false;
        }
        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Message successfully delivered to %s devices (IOS)', $collectionDevice->getSize()));
        return true;
    }
}