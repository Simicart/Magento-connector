<?php

$installer = $this;
$installer->startSetup();
$installer->run("

    DROP TABLE IF EXISTS {$this->getTable('connector_notice_history')};
    CREATE TABLE {$this->getTable('connector_notice_history')} (
        `history_id` int(11) unsigned NOT NULL auto_increment,
        `notice_title` varchar(255) NULL default '',    
        `notice_url` varchar(255) NULL default '',    
        `notice_content` text NULL default '',    
        `notice_sanbox` tinyint(1) NULL default '0',
        `website_id` int (11),
        `device_id` int (11),
        `type` smallint(5) unsigned,
        `category_id` int(10) unsigned  NOT NULL,
        `product_id` int(10) unsigned  NOT NULL,
        `image_url` varchar(255) NOT NULL default '',
        `location` varchar(255) NOT NULL default '',
        `distance` varchar(255) NOT NULL default '',
        `address` varchar(255) NOT NULL default '',
        `city` varchar(255) NOT NULL default '',
        `country` varchar(255) NOT NULL default '',
        `zipcode` varchar(25) NOT NULL default '',
        `state` varchar(255) NOT NULL default '',
        `show_popup` smallint(5) unsigned,
        `created_time` datetime NOT NULL default '0000-00-00 00:00:00',
        `notice_type` smallint(5) unsigned,
        `status` smallint(5) unsigned,
    PRIMARY KEY (`history_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

");
$installer->endSetup();
