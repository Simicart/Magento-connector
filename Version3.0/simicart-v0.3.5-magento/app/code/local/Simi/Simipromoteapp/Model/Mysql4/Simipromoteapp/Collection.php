<?php

class Simi_Simipromoteapp_Model_Mysql4_Simipromoteapp_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct(){
		parent::_construct();
		$this->_init('simipromoteapp/simipromoteapp');
	}
	protected $_isGroupSql = false;
	public function setIsGroupCountSql($value) {
		$this->_isGroupSql = $value;
		return $this;
	}

	public function getSelectCountSql() {
		if ($this->_isGroupSql) {
			$this->_renderFilters();
			$countSelect = clone $this->getSelect();
			$countSelect->reset(Zend_Db_Select::ORDER);
			$countSelect->reset(Zend_Db_Select::LIMIT_COUNT);
			$countSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
			$countSelect->reset(Zend_Db_Select::COLUMNS);
			if(count($this->getSelect()->getPart(Zend_Db_Select::GROUP)) > 0) {
				$countSelect->reset(Zend_Db_Select::HAVING);
				$countSelect->reset(Zend_Db_Select::WHERE);
				$countSelect->reset(Zend_Db_Select::GROUP);
				$countSelect->reset(Zend_Db_Select::DISTINCT);
				$countSelect->distinct(true);
				$group = $this->getSelect()->getPart(Zend_Db_Select::GROUP);
				$countSelect->columns("COUNT(DISTINCT ".implode(", ", $group).")");
			} else {
				$countSelect->columns('COUNT(*)');
			}
			return $countSelect;
		}
		return parent::getSelectCountSql();
	}
}