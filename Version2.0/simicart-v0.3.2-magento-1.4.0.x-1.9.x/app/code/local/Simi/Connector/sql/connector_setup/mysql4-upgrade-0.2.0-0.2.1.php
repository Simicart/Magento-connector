<?php

$installer = $this;
$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('connector_device'), 'latitude', 'varchar(30) NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('connector_device'), 'longitude', 'varchar(30) NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('connector_device'), 'address', 'varchar(255) NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('connector_device'), 'city', 'varchar(255) NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('connector_device'), 'country', 'varchar(255) NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('connector_device'), 'zipcode', 'varchar(25) NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('connector_device'), 'state', 'varchar(255) NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('connector_device'), 'created_time', 'datetime NOT NULL default "0000-00-00 00:00:00"');

$installer->getConnection()->addColumn($installer->getTable('connector_notice'), 'type', 'smallint(5) unsigned');
$installer->getConnection()->addColumn($installer->getTable('connector_notice'), 'category_id', 'int(10) unsigned  NOT NULL');
$installer->getConnection()->addColumn($installer->getTable('connector_notice'), 'product_id', 'int(10) unsigned  NOT NULL');
$installer->getConnection()->addColumn($installer->getTable('connector_notice'), 'image_url', 'varchar(255) NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('connector_notice'), 'location', 'varchar(255) NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('connector_notice'), 'distance', 'varchar(255) NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('connector_notice'), 'address', 'varchar(255) NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('connector_notice'), 'city', 'varchar(255) NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('connector_notice'), 'country', 'varchar(255) NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('connector_notice'), 'zipcode', 'varchar(25) NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('connector_notice'), 'state', 'varchar(255) NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('connector_notice'), 'show_popup', 'smallint(5) unsigned');
$installer->getConnection()->addColumn($installer->getTable('connector_notice'), 'created_time', 'datetime NOT NULL default "0000-00-00 00:00:00"');

$installer->endSetup();
