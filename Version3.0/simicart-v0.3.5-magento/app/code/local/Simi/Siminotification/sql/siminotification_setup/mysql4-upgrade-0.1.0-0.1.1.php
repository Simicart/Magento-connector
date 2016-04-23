<?php

$installer = $this;
$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('connector_device'), 'is_demo', 'tinyint(1) NULL default "3"');
$installer->getConnection()->addColumn($installer->getTable('connector_device'), 'user_email', 'varchar(255) NOT NULL default ""');

$installer->endSetup();
