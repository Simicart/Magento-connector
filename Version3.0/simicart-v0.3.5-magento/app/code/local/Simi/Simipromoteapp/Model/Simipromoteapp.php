<?php

class Simi_Simipromoteapp_Model_Simipromoteapp extends Mage_Core_Model_Abstract
{

	public function _construct(){
		parent::_construct();
		$this->_init('simipromoteapp/simipromoteapp');
	}
}