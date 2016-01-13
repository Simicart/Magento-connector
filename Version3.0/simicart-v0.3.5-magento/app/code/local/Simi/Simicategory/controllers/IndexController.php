<?php

class Simi_Simicategory_IndexController extends Mage_Core_Controller_Front_Action
{
	public function installDbAction(){
		$setup = new Mage_Core_Model_Resource_Setup();
        $installer = $setup;
        $installer->startSetup();
        $installer->run("		
			DROP TABLE IF EXISTS {$setup->getTable('simicategory')};
			CREATE TABLE {$setup->getTable('simicategory')} (
			  `simicategory_id` int(11) unsigned NOT NULL auto_increment,
			  `simicategory_name` varchar(255),
			  `simicategory_filename` varchar(255),
			  `category_id` int(8),
			  `status` smallint(6) NOT NULL default '0',
			  `website_id` int(6),
			  PRIMARY KEY (`simicategory_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;	");
        $installer->endSetup();
        echo "success";
	}
}