<?php

class Simi_Simipromoteapp_Helper_Db extends Mage_Core_Helper_Abstract
{
	public function getDbResource(){
		return Mage::getSingleton('core/resource');
	}
	
	public function getDbTableName(){
		return $this->getDbResource()->getTableName('simipromoteapp');
	}
	
	public function processCommand($query){
		try{
			$resource = $this->getDbResource();
			$writeConnection = $resource->getConnection('core_write');
			$writeConnection->query($query);
		} catch(Exception $ex){
			zend_debug::dump($ex->getMessage());
			exit;
		}
	}

	public function truncateTables($data){
		try{
			if(sizeof($data) > 0){
				$resource = Mage::getSingleton('core/resource');
				$writeConnection = $resource->getConnection('core_write');
				
				$query = "SET FOREIGN_KEY_CHECKS = 0;";
				foreach($data as $name){
					$table_name = 'emailautomation/'.$name;
					$table = $resource->getTableName($table_name);
					$query .= "TRUNCATE TABLE $table;";
				}
				$query .= "SET FOREIGN_KEY_CHECKS = 1;";
				
				echo $query;
				
				$resource = Mage::getSingleton('core/resource');
				$writeConnection = $resource->getConnection('core_write');
				$writeConnection->query($query);
			}
			
		} catch(Exception $ex){
			zend_debug::dump($ex->getMessage());
			exit;
		}
	}
}