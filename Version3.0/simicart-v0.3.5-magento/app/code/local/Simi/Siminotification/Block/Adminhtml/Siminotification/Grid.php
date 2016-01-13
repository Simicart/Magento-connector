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
class Simi_Siminotification_Block_Adminhtml_Siminotification_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct() {
        parent::__construct();
        $this->setId('noticeGrid');
        $this->setDefaultSort('notice_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * prepare collection for block to display
     *
     * @return Simi_Connector_Block_Adminhtml_Banner_Grid
     */
    protected function _prepareCollection() {
        $collection = Mage::getModel('connector/notice')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare columns for this grid
     *
     * @return Simi_Connector_Block_Adminhtml_Banner_Grid
     */
    protected function _prepareColumns() {
        $this->addColumn('notice_id', array(
            'header' => Mage::helper('siminotification')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'notice_id',
        ));

        // $this->addColumn('type', array(
        //     'header' => Mage::helper('siminotification')->__('Redirect To'),
        //     'align' => 'left',
        //     'width' => '120px',
        //     'index' => 'type',
        //     'type' => 'options',
        //     'options' => array(
        //         1 => Mage::helper('siminotification')->__('Product Page'),
        //         2 => Mage::helper('siminotification')->__('Category Page'),
        //         3 => Mage::helper('siminotification')->__('Website'),
        //     ),
        // ));

        $this->addColumn('notice_title', array(
            'header' => Mage::helper('siminotification')->__('Title'),
            'align' => 'left',
            'width' => '150px',
            'index' => 'notice_title',
        ));

        $this->addColumn('notice_content', array(
            'header' => Mage::helper('siminotification')->__('Message'),
            'align' => 'left',
            'index' => 'notice_content',
        ));

        $this->addColumn('website_id', array(
            'header' => Mage::helper('siminotification')->__('Website'),
            'width' => '100px',
            'index' => 'website_id',
            'renderer' => 'connector/adminhtml_grid_renderer_website',
        ));

        $this->addColumn('device_id', array(
            'header' => Mage::helper('siminotification')->__('Device'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'device_id',
            'type' => 'options',
            'options' => array(
                0 => Mage::helper('siminotification')->__('All'),
                1 => Mage::helper('siminotification')->__('IOS'),
                2 => Mage::helper('siminotification')->__('Android'),
            ),
        ));

        $this->addColumn('country', array(
                'header'    => Mage::helper('siminotification')->__('Country'),
                'width'     => '150px',
                'index'     => 'country',
                'type'      => 'options',
                'options'   => Mage::helper('siminotification')->getListCountry(),
        ));

        $this->addColumn('created_time', array(
                'header'    => Mage::helper('siminotification')->__('Created Date'),
                'width'     => '150px',
                'index'     => 'created_time',
                'type'      => 'datetime',
        ));

        // $this->addColumn('notice_sanbox', array(
            // 'header' => Mage::helper('siminotification')->__('Sandbox'),
            // 'align' => 'left',
            // 'width' => '80px',
            // 'index' => 'notice_sanbox',
            // 'type' => 'options',
            // 'options' => array(
                // 1 => 'Yes',
                // 0 => 'No',
            // ),
        // ));

        $this->addColumn('action', array(
            'header' => Mage::helper('siminotification')->__('Action'),
            'width' => '60px',
            'type' => 'action',
            'getter' => 'getId',
            'align' => 'left',
            'actions' => array(
                array(
                    'caption' => Mage::helper('siminotification')->__('Edit'),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'id'
            )),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
            'is_system' => true,
        ));

//        $this->addExportType('*/*/exportCsv', Mage::helper('siminotification')->__('CSV'));
//        $this->addExportType('*/*/exportXml', Mage::helper('siminotification')->__('XML'));

        return parent::_prepareColumns();
    }

    /**
     * prepare mass action for this grid
     *
     * @return Magestore_Madapter_Block_Adminhtml_Madapter_Grid
     */
    protected function _prepareMassaction() {
        $this->setMassactionIdField('notice_id');
        $this->getMassactionBlock()->setFormFieldName('connector');

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