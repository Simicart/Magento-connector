<?php
/**
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    
 * @package     Siminotification
 * @copyright   Copyright (c) 2012 
 * @license     
 */

 /**
 * Siminotification Index Controller
 * 
 * @category    
 * @package     Siminotification
 * @author      Developer
 */
class Simi_Siminotification_IndexController extends Mage_Core_Controller_Front_Action
{
	/**
	 * index action
	 */
	public function testAction(){
		$lat= 21.001825;
		// 55.1659402; //latitude
		$lng= 105.823845;
		// -1.5459312; //longitude
		$address= $this->getAddress($lat,$lng);
		if($address)
		{
		echo $address;
		}
		else
		{
		echo "Not found";
		}
	}

	public function getAddress($lat,$lng)
	{
		$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
		$json = @file_get_contents($url);
		$data = json_decode($json);
		$status = $data->status;
		if($status=="OK"){
			$addresses = array();
			$address = '';
			// Zend_Debug::dump($data->results[0]);die();
			for($j=0; $j<count($data->results[0]->address_components); $j++){
				$addressComponents = $data->results[0]->address_components[$j];
				$types = $addressComponents->types;
				if(in_array('street_number', $types)){
					$address .= $addressComponents->long_name;
				}
				if(in_array('route', $types)){
					$address .= ' '.$addressComponents->long_name;
				}
				if(in_array('locality', $types)){
					$address .= ', '.$addressComponents->long_name;
				}
				if(in_array('postal_town', $types) || in_array('administrative_area_level_1', $types)){
					$city .= $addressComponents->long_name;
				}
				if(in_array('administrative_area_level_2', $types)){
					$state .= $addressComponents->long_name;
				}
				if(in_array('country', $types)){
					$country .= $addressComponents->short_name;
				}
				if(in_array('postal_code', $types)){
					$zipcode .= $addressComponents->long_name;
				}
			}
			$addresses['address'] = $address;
			$addresses['city'] = $city;
			$addresses['state'] = $state;
			$addresses['country'] = $country;
			$addresses['zipcode'] = $zipcode;
			// Zend_Debug::dump($addresses);die();
			return $addresses;
		}else{
			return false;
		}
	}

	public function installDB(){

		$setup = new Mage_Core_Model_Resource_Setup();
        // Zend_Debug::dump(get_class($setup));die();	
        $installer = $setup;
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
		$installer->run("
		    DROP TABLE IF EXISTS {$setup->getTable('connector_notice_history')};
		    CREATE TABLE {$setup->getTable('connector_notice_history')} (
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
	}
	
	public function updateDBv1Action(){
		$setup = new Mage_Core_Model_Resource_Setup();
        $installer = $setup;
		$installer->startSetup();
		$installer->getConnection()->addColumn($installer->getTable('connector_device'), 'is_demo', 'tinyint(1) NULL default "3"');
		$installer->getConnection()->addColumn($installer->getTable('connector_device'), 'user_email', 'varchar(255) NOT NULL default ""');
		$installer->getConnection()->addColumn($installer->getTable('connector_notice_history'), 'devices_pushed', 'text NULL default ""'); 
		$installer->endSetup();
		echo 'completed';
	}
}