<?php

class Simi_Simipromoteapp_Model_Status extends Varien_Object
{
	const STATUS_ENABLED	= 1;
	const STATUS_DISABLED	= 0;

	const SUBSCRIBER_YES = 1;
	const SUBSCRIBER_NO = 0;

	const TYPE_REGISTER = 1;
	const TYPE_SUBSCRIBER = 2;
	const TYPE_PURCHASING = 3;

	const TYPE_EMAIL_SENT = 1;
	const TYPE_EMAIL_OPEN = 2;

	static public function getOptionArray(){
		return array(
			self::STATUS_ENABLED	=> Mage::helper('simipromoteapp')->__('Yes'),
			self::STATUS_DISABLED   => Mage::helper('simipromoteapp')->__('No')
		);
	}
	
	static public function getOptionHash(){
		$options = array();
		foreach (self::getOptionArray() as $value => $label)
			$options[] = array(
				'value'	=> $value,
				'label'	=> $label
			);
		return $options;
	}

	static public function getSubscriberOptionArray(){
		return array(
			self::STATUS_ENABLED	=> Mage::helper('simipromoteapp')->__('Yes'),
			self::STATUS_DISABLED   => Mage::helper('simipromoteapp')->__('No')
		);
	}

	static public function getSubscriberOptionHash(){
		$options = array();
		foreach (self::getSubscriberOptionArray() as $value => $label)
			$options[] = array(
				'value'	=> $value,
				'label'	=> $label
			);
		return $options;
	}
}