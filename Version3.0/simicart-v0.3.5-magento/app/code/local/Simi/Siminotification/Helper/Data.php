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
 * Siminotification Data
 * 
 * @category    
 * @package     Siminotification
 * @author      Developer
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
		$collectionDevice = $data['collection_device'];
		$pusshedArray = array();
		foreach ($collectionDevice as $item) {
			if (($data['website_id']== null) || ($item['website_id'] && ($data['website_id']== $item['website_id'])))
				$pusshedArray[] = $item['device_id'];
		} 
		$data['devices_pushed']= implode(",",$pusshedArray);
        $history->setData($data);
        $history->save();
        return $trans;
    }

    public function send(&$data) {
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
        $collectionDevice2 = Mage::getModel('connector/device')->getCollection();

        if ($data['country'] != "0") {
            $country_id = trim($data['country']);
            $collectionDevice->addFieldToFilter('country', array('like' => '%' . $data['country'] . '%'));
            $collectionDevice2->addFieldToFilter('country', array('like' => '%' . $data['country'] . '%'));
        }
        if (isset($data['state']) && ($data['state'] != null)) {
            $city = trim($city);
            $collectionDevice->addFieldToFilter('state', array('like' => '%' . $data['state'] . '%'));
            $collectionDevice2->addFieldToFilter('state', array('like' => '%' . $data['state'] . '%'));
        }
        if (isset($data['address']) && ($data['address'] != null)) {           
            $collectionDevice->addFieldToFilter('address', $data['address']);
            $collectionDevice2->addFieldToFilter('address', $data['address']);
        }
        if (isset($data['city']) && ($data['city'] != null)) {            
            $collectionDevice->addFieldToFilter('city', array('like' => '%' . $data['city'] . '%'));
            $collectionDevice2->addFieldToFilter('city', array('like' => '%' . $data['city'] . '%'));
        }
        if (isset($data['zipcode']) && ($data['zipcode'] != null)) {            
            $collectionDevice->addFieldToFilter('zipcode', array('like' => '%' . $data['zipcode'] . '%'));
            $collectionDevice2->addFieldToFilter('zipcode', array('like' => '%' . $data['zipcode'] . '%'));
        }
		switch ($data['notice_sanbox']) {
			case '1': $sendLive = 0; $sendTest = 1; $collectionDevice->addFieldToFilter('is_demo',1); break;
			case '2': $sendLive = 1; $sendTest = 0; $collectionDevice->addFieldToFilter('is_demo',0); break;
			default: $sendLive = 1; $sendTest = 1; 
		}
		
        if ((int) $data['device_id'] != 0) {
            if ((int) $data['device_id'] == 2) {
                //send android
                $collectionDevice->addFieldToFilter('plaform_id', array('eq' => 3));
				$result = $this->sendAndroid($collectionDevice, $data);
				$data['collection_device'] = $collectionDevice->getData(); 
				return $result;                
            } else {
                //send IOS
                $collectionDevice->addFieldToFilter('plaform_id', array('neq' => 3));
				$result = $this->sendIOS($collectionDevice, $data);
				$data['collection_device'] = $collectionDevice->getData(); 
				return $result;                
            }
        } else {
            //send all
            $collection = $collectionDevice->addFieldToFilter('is_demo', '0');                       
            $collectionAndroid = $collectionDevice2->addFieldToFilter('is_demo', '0');     

            $collection->addFieldToFilter('plaform_id', array('neq' => 3));        
            $collectionAndroid->addFieldToFilter('plaform_id', array('eq' => 3));
          
            $resultIOS = $this->sendIOS($collection, $data);
			
            $resultAndroid = $this->sendAndroid($collectionAndroid, $data);			
			$data['collection_device'] = $collectionDevice->getData(); 
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
            'height'     => $data['height'],
            'width'     => $data['width'],
            'show_popup'   => $data['show_popup'],
        );
        $payload = json_encode($body);
        $totalDevice = 0;
		
		if ($data['notice_sanbox'] == '0') { //send the old way
			foreach ($collectionDevice as $item) {
			$ctx = stream_context_create();
			stream_context_set_option($ctx, 'ssl', 'local_cert', $ch);
			//$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
			$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
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
			$totalDevice++;					
			fclose($fp);
			}	
		}
		else {
			$i = 0;		
			$tokenArray = array();			
			foreach ($collectionDevice as $item) {
				if ($i == 100) {
					$this->repeatSendiOS($tokenArray, $payload, $ch, $dir);					
					$i =0;
					$tokenArray = array();					
				}
				if (strlen ($item->getDeviceToken())<70) {
					$tokenArray[] = $item->getDeviceToken();	
				}					
				else 
					continue;
				$i++;
				$totalDevice++;
			}
			if ($i<100)
				$this->repeatSendiOS($tokenArray, $payload, $ch, $dir);
		}
		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Message successfully delivered to %s devices (IOS)', $totalDevice));
		return true;
			
    }
	
	public function repeatSendiOS($tokenArray, $payload, $ch, $dir){	
		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', $ch);
		$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
		if (!$fp) {
		 Mage::getSingleton('adminhtml/session')->addError("Failed to connect:" . $err . $errstr . PHP_EOL . "(IOS)");
			return;
		}		
		foreach ($tokenArray as $deviceToken) {
			$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
			// Send it to the server
			$result = fwrite($fp, $msg, strlen($msg));
			if (!$result) {
				Mage::getSingleton('adminhtml/session')->addError('Message not delivered (IOS)' . PHP_EOL);
				return false;
			}
		}			
		fclose($fp);
	}

    public function sendAndroid($collectionDevice, $data) {
        //$api_key = Mage::getStoreConfig('connector/android_key');
//        $api_key = "AIzaSyALAL5f9FOjn2e9s3WkJJvyTvWN9LAyDTs";
        // please enter the registration id of the device on which you want to send the message
        $total = count($collectionDevice);
        $this->checkIndex($data);
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
            'height'     => $data['height'],
            'width'     => $data['width'],
            'show_popup'   => $data['show_popup'],
        );
        $this->repeatSendAnddroid($total, $collectionDevice->getData(), $message);
        return true;
    }
	 
	public function repeatSendAnddroid($total, $collectionDevice, $message){
        $size = $total;
        while (true) {
            $from_user = 0;
            $check = $total - 999;
            if($check <= 0){
                //send to  (total+from_user) user from_user
                $is = $this->sendTurnAnroid($collectionDevice, $from_user, $from_user+$total, $message);
                if($is == false){
                    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Message not delivered (Android)'));
                    return false;
                } 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Message successfully delivered to %s devices (Android)', $size));
                return true;
            }else{
                //send to 100 user from_user
                $is = $this->sendTurnAnroid($collectionDevice, $from_user, $from_user+999, $message);
                if($is == false){
                    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Message not delivered (Android)'));
                    return false;
                } 
                $total = $check;
                $from_user += 999;
            }    
        }
    }

    public function sendTurnAnroid($collectionDevice, $from, $to, $message){
        $registrationIDs = array();
        for ($i = $from; $i <= $to; $i++) {
            $item = $collectionDevice[$i];
            $registrationIDs[] = $item['device_token'];
        }

        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $registrationIDs,
            'data' => array("message" => $message),
        );

        $api_key = Mage::getStoreConfig('connector/android_key');
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
            return false;
        }
        return true;
     
    }
	public function checkIndex(&$data){
        if(!isset($data['type'])){
            $data['type'] = '';
        }
        if(!isset($data['product_id'])){
            $data['product_id'] = '';
        }
        if(!isset($data['category_id'])){
            $data['category_id'] = '';
        }
        if(!isset($data['category_name'])){
            $data['category_name'] = '';
        }
        if(!isset($data['has_child'])){
            $data['has_child'] = '';
        }
        if(!isset($data['image_url'])){
            $data['image_url'] = '';
        }
        if(!isset($data['height'])){
            $data['height'] = '';
        }
        if(!isset($data['width'])){
            $data['width'] = '';
        }
        if(!isset($data['show_popup'])){
            $data['show_popup'] = '';
        }
    }

}