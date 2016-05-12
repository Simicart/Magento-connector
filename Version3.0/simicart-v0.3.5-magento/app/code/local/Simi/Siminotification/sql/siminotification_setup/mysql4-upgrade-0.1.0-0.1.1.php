<?php

$installer = $this;
$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('connector_device'), 'is_demo', 'tinyint(1) NULL default "3"');
$installer->getConnection()->addColumn($installer->getTable('connector_device'), 'user_email', 'varchar(255) NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('connector_notice_history'), 'devices_pushed', 'text NULL default ""'); 
$installer->getConnection()->addColumn($installer->getTable('connector_notice_history'), 'notice_id', 'int NULL'); 

$installer->endSetup();
