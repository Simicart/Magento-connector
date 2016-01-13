<?php

class Simi_Simicategory_Block_Adminhtml_Simicategory_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct(){
		parent::__construct();
		$this->setId('simicategoryGrid');
		$this->setDefaultSort('simicategory_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection(){
		$collection = Mage::getModel('simicategory/simicategory')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns(){
		$this->addColumn('simicategory_id', array(
			'header'	=> Mage::helper('simicategory')->__('ID'),
			'align'	 =>'right',
			'width'	 => '50px',
			'index'	 => 'simicategory_id',
		));

		$this->addColumn('simicategory_name', array(
			'header'	=> Mage::helper('simicategory')->__('Category Name'),
			'align'	 =>'left',
			'index'	 => 'simicategory_name',
		));

		 $this->addColumn('website_id', array(
            'header' => Mage::helper('simicategory')->__('Website'),
            'align' => 'left',
            'width' => '200px',
            'index' => 'website_id',
            'type' => 'options',
            'options' => Mage::getSingleton('connector/status')->getWebGird(),
             'filter' => false
        ));

		$this->addColumn('status', array(
			'header'	=> Mage::helper('simicategory')->__('Status'),
			'align'	 => 'left',
			'width'	 => '80px',
			'index'	 => 'status',
			'type'		=> 'options',
			'options'	 => array(
				1 => 'Enabled',
				2 => 'Disabled',
			),
		));

		$this->addColumn('action',
			array(
				'header'	=>	Mage::helper('simicategory')->__('Action'),
				'width'		=> '100',
				'type'		=> 'action',
				'getter'	=> 'getId',
				'actions'	=> array(
					array(
						'caption'	=> Mage::helper('simicategory')->__('Edit'),
						'url'		=> array('base'=> '*/*/edit'),
						'field'		=> 'id'
					)),
				'filter'	=> false,
				'sortable'	=> false,
				'index'		=> 'stores',
				'is_system'	=> true,
		));

		$this->addExportType('*/*/exportCsv', Mage::helper('simicategory')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('simicategory')->__('XML'));

		return parent::_prepareColumns();
	}

	protected function _prepareMassaction(){
		$this->setMassactionIdField('simicategory_id');
		$this->getMassactionBlock()->setFormFieldName('simicategory');

		$this->getMassactionBlock()->addItem('delete', array(
			'label'		=> Mage::helper('simicategory')->__('Delete'),
			'url'		=> $this->getUrl('*/*/massDelete'),
			'confirm'	=> Mage::helper('simicategory')->__('Are you sure?')
		));

		$statuses = Mage::getSingleton('simicategory/status')->getOptionArray();

		array_unshift($statuses, array('label'=>'', 'value'=>''));
		$this->getMassactionBlock()->addItem('status', array(
			'label'=> Mage::helper('simicategory')->__('Change status'),
			'url'	=> $this->getUrl('*/*/massStatus', array('_current'=>true)),
			'additional' => array(
				'visibility' => array(
					'name'	=> 'status',
					'type'	=> 'select',
					'class'	=> 'required-entry',
					'label'	=> Mage::helper('simicategory')->__('Status'),
					'values'=> $statuses
				))
		));
		return $this;
	}

	public function getRowUrl($row){
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
}