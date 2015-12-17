<?php

class Simi_Simicategory_ApiController extends Simi_Connector_Controller_Action
{
	public function get_categoriesAction(){
    	$information = Mage::getModel('simicategory/simicategory')->getCategoires();
        $this->_printDataJson($information);
	}

	public function get_currenciesAction(){
		$information = Mage::getModel('simicategory/simicategory')->getCurrencies();
        $this->_printDataJson($information);
	}

	public function save_currencyAction(){
		$data = $this->getData();
        if ($data && $data->currency) {
            Mage::app()->getStore()->setCurrentCurrencyCode($data->currency);        	
        }
        $information = Mage::getModel('connector/config_app')->statusSuccess();
        $this->_printDataJson($information);
	}
}