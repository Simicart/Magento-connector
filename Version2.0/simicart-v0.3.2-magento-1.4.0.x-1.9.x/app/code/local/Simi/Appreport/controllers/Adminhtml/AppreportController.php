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
 * @category    Magestore
 * @package     Magestore_Appreport
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

/**
 * Appreport Adminhtml Controller
 * 
 * @category    Magestore
 * @package     Magestore_Appreport
 * @author      Magestore Developer
 */
class Simi_Appreport_Adminhtml_AppreportController extends Mage_Adminhtml_Controller_Action {

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

}
