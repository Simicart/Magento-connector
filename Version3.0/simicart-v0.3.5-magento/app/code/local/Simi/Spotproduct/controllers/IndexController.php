<?php
/**
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    
 * @package     Spotproduct
 * @copyright   Copyright (c) 2012 
 * @license     
 */

 /**
 * Spotproduct Index Controller
 * 
 * @category    
 * @package     Spotproduct
 * @author      Developer
 */
class Simi_Spotproduct_IndexController extends Simi_Connector_Controller_Action {

    /**
     * index action
     */
    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }
    
    public function get_spot_productsAction(){
        $data = $this->getData();        
        $information = Mage::getModel('spotproduct/spotproduct')->getSpotProduct($data);
        $this->_printDataJson($information);        
    }
	
	public function get_spot_products_v2Action(){
        $data = $this->getData();         
        $information = Mage::getModel('spotproduct/spotproduct')->getSpotProducts($data);
        $this->_printDataJson($information);        
    }

    public function refresh_spot_products_v2Action(){
                $file = Mage::getBaseDir('code').'/local/Simi/Spotproduct/controllers/spotData.json';
        $jsontoEncode = array();
                file_put_contents($file, json_encode($jsontoEncode));
                echo 'done';                        
    }
}