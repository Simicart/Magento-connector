<?php

class Simi_Simipromoteapp_Model_Observer
{
	
	public function customerRegister(Varien_Event_Observer $observer){
		$customer = $observer->getCustomer();

		$isEnable = Mage::helper('simipromoteapp/email')->isEnable();
		if($isEnable && $customer->getId()){
			// send email
			$data = array(
				'name' => $customer->getFirstname(),
				'email' => $customer->getEmail(),
				'is_subscriber' => Simi_Simipromoteapp_Model_Status::SUBSCRIBER_NO
			);
			Mage::helper('simipromoteapp/email')->sendEmail($data, Simi_Simipromoteapp_Model_Status::TYPE_REGISTER);
		}
	}
	
	public function onepageSuccess(Varien_Event_Observer $observer){
		
		$isEnable = Mage::helper('simipromoteapp/email')->isEnable();
		if($isEnable){
			$order = new Mage_Sales_Model_Order();
			$incrementId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
			$order->loadByIncrementId($incrementId);
			$customer = Mage::getModel('customer/customer')->load($order->getData('customer_id'));

			if($customer->getId()) {
				// send email
				$data = array(
					'name' => $customer->getFirstname(),
					'email' => $customer->getEmail(),
					'is_subscriber' => Simi_Simipromoteapp_Model_Status::SUBSCRIBER_NO
				);
				Mage::helper('simipromoteapp/email')->sendEmail($data, Simi_Simipromoteapp_Model_Status::TYPE_PURCHASING);
			}
		}
				
	}

	public function subscribedToNewsletter(Varien_Event_Observer $observer)
	{
		$event = $observer->getEvent();
		$subscriber = $event->getDataObject();
		$data = $subscriber->getData();
		$email = $data['subscriber_email'];

		$statusChange = $subscriber->getIsStatusChanged();

		$isEnable = Mage::helper('simipromoteapp/email')->isEnable();
		if($isEnable){
			if ($data['subscriber_status'] == "1" && $statusChange == true) {
				//code to handle if customer is just subscribed...
				$name = explode('@',$email);
				$data = array(
					'name' => $name[0],
					'email' => $email,
					'is_subscriber' => Simi_Simipromoteapp_Model_Status::SUBSCRIBER_YES
				);
				Mage::helper('simipromoteapp/email')->sendEmail($data, Simi_Simipromoteapp_Model_Status::TYPE_SUBSCRIBER);
			}
		}

	}

}      
