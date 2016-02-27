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

/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * create appreport table
 */
$installer->run("

DROP TABLE IF EXISTS {$this->getTable('appreport_transactions')};

CREATE TABLE {$this->getTable('appreport_transactions')} (
  `transaction_id` int(11) unsigned NOT NULL auto_increment,
  `order_id` int(30),  
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

$installer->endSetup();

