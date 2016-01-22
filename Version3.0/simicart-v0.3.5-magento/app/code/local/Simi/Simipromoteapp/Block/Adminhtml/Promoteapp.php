<?php

class Simi_Simipromoteapp_Block_Adminhtml_Promoteapp extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct(){
		$this->_controller = 'adminhtml_simipromoteapp';
		$this->_blockGroup = 'simipromoteapp';
		$this->_headerText = Mage::helper('simipromoteapp')->__('');
		$this->_addButtonLabel = Mage::helper('simipromoteapp')->__('');
		parent::__construct();
		$this->_removeButton('add');

		$is_enable = Mage::helper('simipromoteapp/chart')->isEnable();

		if($is_enable)
			$this->setTemplate('simipromoteapp/charts/chart.phtml');
	}

	public function getFirstDateOfMonth(){
		return $this->getHelperDateTime()->getFirstDateOfCurrentMonth();
	}

	public function getLastDateOfMonth(){
		return $this->getHelperDateTime()->getLastDateOfCurrentMonth();
	}

	public function getHelperDateTime(){
		return Mage::helper('simipromoteapp/dateTime');
	}

	public function getHelperChart(){
		return Mage::helper('simipromoteapp/chart');
	}

	public function getHelperData(){
		return Mage::helper('simipromoteapp');
	}

	public function getTextByApp(){
		return $this->getHelperData()->__($this->getHelperChart()->getTextByApp());
	}

	public function getTextByWebsite(){
		return $this->getHelperData()->__($this->getHelperChart()->getTextByWebsite());
	}

	public function getChartTitle(){
		return $this->getHelperData()->__($this->getHelperChart()->getChartTitle());
	}

	public function getPercent(){
		return $this->getHelperData()->__($this->getHelperChart()->getPercent());
	}

}