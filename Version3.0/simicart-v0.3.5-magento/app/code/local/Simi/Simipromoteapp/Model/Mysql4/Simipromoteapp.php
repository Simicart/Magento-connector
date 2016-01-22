<?php

class Simi_Simipromoteapp_Model_Mysql4_Simipromoteapp extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct(){
		$this->_init('simipromoteapp/simipromoteapp', 'simipromoteapp_id');
	}
}