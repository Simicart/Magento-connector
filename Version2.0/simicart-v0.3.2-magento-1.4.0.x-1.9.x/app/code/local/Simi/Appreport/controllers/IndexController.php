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
 * Appreport Index Controller
 * 
 * @category    Magestore
 * @package     Magestore_Appreport
 * @author      Magestore Developer
 */
class Simi_Appreport_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * index action
     */
    public function checkInstallAction() {
        echo "1";
        exit();
    }

    public function installDbAction() {
        $setup = new Mage_Core_Model_Resource_Setup();
        $installer = $setup;
        $installer->startSetup();

        $installer->run("

DROP TABLE IF EXISTS {$setup->getTable('appreport_transactions')};

CREATE TABLE {$setup->getTable('appreport_transactions')} (
  `transaction_id` int(11) unsigned NOT NULL auto_increment,
  `order_id` int(30),  
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


        ");

        $installer->endSetup();
        echo "success";
    }

  public function getOrdersAction(){
    $collection = Mage::getResourceModel('sales/order_grid_collection');
    echo $this->createOrder($collection);
    exit();
  }

  public function getOrdersSimiAction(){
    $collection = Mage::getResourceModel('sales/order_grid_collection');
     //$collection_via_simi = Mage::getModel('appreport/appreport')->getCollection();
    $collection->getSelect()->join(array('transaction'=> 'appreport_transactions'), 'transaction.order_id = main_table.entity_id');
    echo $this->createOrder($collection);
    exit();
  }

  public function createOrder($collection){
    $orders = array();
    foreach ($collection as $item){
      $order = array(
        'id' => $item->getIncrementId(),
        'base_grand_total' => $item->getData('base_grand_total'),
        'grand_total' => $item->getData('grand_total'),
        'status' => $item->getData('status'),
        );
      $orders[] = $order;
    }
    return $orders;
  }

}