<?php

class Simi_Simipromoteapp_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function isEnable($store = null) {
        return Mage::getStoreConfig('simipromoteapp/general/enable', $store);
    }

    public function getConfig($code, $store = null) {
        return Mage::getStoreConfig('simipromoteapp/' . $code, $store);
    }

    public function getHelperDb(){
        return Mage::helper('simipromoteapp/db');
    }

    public function getImageCms($path){
        return Mage::getBaseUrl('media') . 'simicms' . DS . $path;
    }
}