<?php

/**
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    
 * @package     Appreport
 * @copyright   Copyright (c) 2012 
 * @license     
 */

/**
 * Appreport Adminhtml Controller
 * 
 * @category    
 * @package     Appreport
 * @author      Developer
 */
class Simi_Appreport_Adminhtml_Appreport_AppreportController extends Mage_Adminhtml_Controller_Action {

    /**
     * init layout and set active for current menu
     *
     * @return Simi_Appreport_Adminhtml_AppreportController
     */
    protected function _initAction() {
        $this->loadLayout()
            ->_setActiveMenu('appreport/appreport')
            ->_addBreadcrumb(
                Mage::helper('adminhtml')->__('Transactions'), Mage::helper('adminhtml')->__('App Transactions')
        );
        return $this;
    }

    /**
     * index action
     */
    public function indexAction() {
        $this->_initAction()
            ->renderLayout();
    }

    /**
     * export grid item to CSV type
     */
    public function exportCsvAction() {
        $fileName = 'appreport.csv';
        $content = $this->getLayout()
            ->createBlock('appreport/adminhtml_appreport_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export grid item to XML type
     */
    public function exportXmlAction() {
        $fileName = 'appreport.xml';
        $content = $this->getLayout()
            ->createBlock('appreport/adminhtml_appreport_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('appreport');
    }

    /**
     * gird action
     */
    public function gridAction(){       
        $this->loadLayout();
        $this->renderLayout();
    }

}
