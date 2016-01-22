<?php

class Simi_Simipromoteapp_OrderController extends Mage_Core_Controller_Front_Action
{
	public function reportAction(){
		$from_date = $this->getRequest()->getParam('from_date');
		$to_date = $this->getRequest()->getParam('to_date');

		$data = array(
			'from_date' => $from_date,
			'to_date' => $to_date,
		);

		$output = Mage::helper('simipromoteapp/order')->getInfo($data);

		$json = json_encode($output);

		$this	->getResponse()
				->clearHeaders()
				->setHeader('Content-Type', 'application/json')
				->setBody($json);
	}

}