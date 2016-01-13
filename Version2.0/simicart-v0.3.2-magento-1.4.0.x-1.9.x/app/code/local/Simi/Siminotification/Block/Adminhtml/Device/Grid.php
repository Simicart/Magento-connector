<?php
/**
 * Magestore
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category 	Magestore
 * @package 	Magestore_Siminotification
 * @copyright 	Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license 	http://www.magestore.com/license-agreement.html
 */

 /**
 * Siminotification Grid Block
 * 
 * @category 	Magestore
 * @package 	Magestore_Siminotification
 * @author  	Magestore Developer
 */
class Simi_Siminotification_Block_Adminhtml_Device_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct() {
        parent::__construct();
        $this->setId('deviceGrid');
        $this->setDefaultSort('device_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * prepare collection for block to display
     *
     * @return Simi_Connector_Block_Adminhtml_Banner_Grid
     */
    protected function _prepareCollection() {
        $collection = Mage::getModel('connector/device')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare columns for this grid
     *
     * @return Simi_Connector_Block_Adminhtml_Banner_Grid
     */
    protected function _prepareColumns() {
        $this->addColumn('device_id', array(
            'header' => Mage::helper('siminotification')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'device_id',
        ));

        $this->addColumn('website_id', array(
            'header' => Mage::helper('siminotification')->__('Website'),
            'width' => '200px',
            'index' => 'website_id',
            'renderer' => 'connector/adminhtml_grid_renderer_website',
        ));

        $this->addColumn('plaform_id', array(
            'header'    => Mage::helper('siminotification')->__('Device Type'),
            'align'  => 'left',
            'width'  => '100px',
            'index'  => 'plaform_id',
            'type'      => 'options',
            'options'    => array(
                3 => Mage::helper('siminotification')->__('Android'),
                1 => Mage::helper('siminotification')->__('iPhone'),
                2 => Mage::helper('siminotification')->__('iPad'),
            ),
        ));

        $this->addColumn('city', array(
            'header'    => Mage::helper('siminotification')->__('City'),
            'width'  => '150px',
            'index'  => 'city',
        ));
                
        $this->addColumn('state', array(
                'header'    => Mage::helper('siminotification')->__('State/Province'),
                'width'     => '150px',
                'index'     => 'state',
        ));
        
        $this->addColumn('country', array(
                'header'    => Mage::helper('siminotification')->__('Country'),
                'width'     => '150px',
                'index'     => 'country',
                'type'      => 'options',
                'options'   => Mage::helper('siminotification')->getListCountry(),
        ));

        // $this->addColumn('device_token', array(
        //     'header' => Mage::helper('siminotification')->__('Device Token'),
        //     'align' => 'left',
        //     'index' => 'device_token',
        // ));

        $this->addColumn('created_time', array(
            'header'    => Mage::helper('siminotification')->__('Created Date'),
            'width'     => '150px',
            'align'     =>'right',
            'index'     => 'created_time',
            'type'      => 'datetime'
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('siminotification')->__('Action'),
            'width' => '80px',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('siminotification')->__('View'),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'id'
            )),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
            'is_system' => true,
        ));

        return parent::_prepareColumns();
    }

    /**
     * prepare mass action for this grid
     *
     * @return Magestore_Madapter_Block_Adminhtml_Madapter_Grid
     */
    protected function _prepareMassaction() {
        $this->setMassactionIdField('notice_id');
        $this->getMassactionBlock()->setFormFieldName('siminotification');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('siminotification')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('siminotification')->__('Are you sure?')
        ));

        return $this;
    }

    /**
     * get url for each row in grid
     *
     * @return string
     */
    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}