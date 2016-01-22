<?php

class Simi_Simipromoteapp_Block_Adminhtml_Simipromoteapp_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct(){
		parent::__construct();
		$this->setId('simipromoteappGrid');
		$this->setDefaultSort('simipromoteapp_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection(){
		$collection = Mage::getModel('simipromoteapp/simipromoteapp')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns(){
		$this->addColumn('simipromoteapp_id', array(
			'header'	=> Mage::helper('simipromoteapp')->__('ID'),
			'align'	 =>'right',
			'width'	 => '50px',
			'index'	 => 'simipromoteapp_id',
		));

		$this->addColumn('customer_name', array(
			'header'	=> Mage::helper('simipromoteapp')->__('Customer Name'),
			'align'	 =>'left',
			'index'	 => 'customer_name',
		));

		$this->addColumn('customer_email', array(
			'header'	=> Mage::helper('simipromoteapp')->__('Customer Email'),
			'index'	 => 'customer_email',
		));

		$this->addColumn('is_open', array(
			'header'	=> Mage::helper('simipromoteapp')->__('Open Email?'),
			'align'	 => 'left',
			'width'	 => '80px',
			'index'	 => 'is_open',
			'type'		=> 'options',
			'options'	 => array(
				1 => 'Yes',
				0 => 'No',
			),
		));

//		$this->addColumn('action',
//			array(
//				'header'	=>	Mage::helper('simipromoteapp')->__('Action'),
//				'width'		=> '100',
//				'type'		=> 'action',
//				'getter'	=> 'getId',
//				'actions'	=> array(
//					array(
//						'caption'	=> Mage::helper('simipromoteapp')->__('Edit'),
//						'url'		=> array('base'=> '*/*/edit'),
//						'field'		=> 'id'
//					)),
//				'filter'	=> false,
//				'sortable'	=> false,
//				'index'		=> 'stores',
//				'is_system'	=> true,
//		));

		$this->addExportType('*/*/exportCsv', Mage::helper('simipromoteapp')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('simipromoteapp')->__('XML'));

		return parent::_prepareColumns();
	}

	protected function _prepareMassaction(){
		$this->setMassactionIdField('simipromoteapp_id');
		$this->getMassactionBlock()->setFormFieldName('simipromoteapp');

		$this->getMassactionBlock()->addItem('delete', array(
			'label'		=> Mage::helper('simipromoteapp')->__('Delete'),
			'url'		=> $this->getUrl('*/*/massDelete'),
			'confirm'	=> Mage::helper('simipromoteapp')->__('Are you sure?')
		));

		return $this;
	}

	public function getRowUrl($row){
		//return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
}