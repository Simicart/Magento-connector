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
 * @package     Magestore_Madapter
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

/**
 * Connector Model
 * 
 * @category    Simi
 * @package     Simi_Connector
 * @author      Simi Developer
 */
class Simi_Connector_Model_Device extends Simi_Connector_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('connector/device');
    }

    public function setDataDevice($data, $device_id) {
        $website = Mage::app()->getStore()->getWebsiteId();  
        $latitude = $data->latitude;
        $longitude = $data->longitude;
        $addresses = $this->getAddress($latitude, $longitude);
        if($addresses)
            $this->setData($addresses);      
        $this->setData('device_token', $data->device_token);
        $this->setData('plaform_id', $device_id);
        $this->setData('website_id', $website);   
        $this->setData('latitude', $data->latitude);
        $this->setData('longitude', $data->longitude);
        $this->setData('created_time', now());
        try {
            $this->save();
            $information = $this->statusSuccess();
            return $information;
        } catch (Exception $e) {
            if (is_array($e->getMessage())) {
                $information = $this->statusError($e->getMessage());
                return $information;
            } else {
                $information = $this->statusError(array($e->getMessage()));
                return $information;
            }
        }
    }

    public function getAddress($lat,$lng){
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
        $json = @file_get_contents($url);
        $data = json_decode($json);
        $status = $data->status;
        if($status=="OK"){
            $addresses = array();
            $address = '';
            for($j=0; $j<count($data->results[0]->address_components); $j++){
                $addressComponents = $data->results[0]->address_components[$j];
                $types = $addressComponents->types;
                if(in_array('street_number', $types)){
                    $address .= $addressComponents->long_name;
                }
                if(in_array('route', $types)){
                    $address .= ' '.$addressComponents->long_name;
                }
                if(in_array('locality', $types)){
                    $address .= ', '.$addressComponents->long_name;
                }
                if(in_array('postal_town', $types) || in_array('administrative_area_level_1', $types)){
                    $city .= $addressComponents->long_name;
                }
                if(in_array('administrative_area_level_2', $types)){
                    $state .= $addressComponents->long_name;
                }
                if(in_array('country', $types)){
                    $country .= $addressComponents->short_name;
                }
                if(in_array('postal_code', $types)){
                    $zipcode .= $addressComponents->long_name;
                }
            }
            $addresses['address'] = $address;
            $addresses['city'] = $city;
            $addresses['state'] = $state;
            $addresses['country'] = $country;
            $addresses['zipcode'] = $zipcode;
            return $addresses;
        }else{
            return false;
        }
    }

}