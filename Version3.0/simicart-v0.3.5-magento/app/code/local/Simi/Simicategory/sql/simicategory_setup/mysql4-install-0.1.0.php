<?php

$installer = $this;
$installer->startSetup();
$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('simicategory')};
    CREATE TABLE {$this->getTable('simicategory')} (
      `simicategory_id` int(11) unsigned NOT NULL auto_increment,
      `simicategory_name` varchar(255),
      `simicategory_filename` varchar(255),
      `category_id` int(8),
      `status` smallint(6) NOT NULL default '0',
      `website_id` int(6),
      PRIMARY KEY (`simicategory_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
$installer->endSetup();
