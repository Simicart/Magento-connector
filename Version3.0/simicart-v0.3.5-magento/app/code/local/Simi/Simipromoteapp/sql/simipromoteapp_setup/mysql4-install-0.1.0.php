<?php

$installer = $this;
$installer->startSetup();

    $purchased_subject = Mage::helper('simipromoteapp/content')->getPurchasingSubject();
    $purchased_content = Mage::helper('simipromoteapp/content')->getPurchasingContent();

    $register_subject = Mage::helper('simipromoteapp/content')->getRegisterSubject();
    $register_content = Mage::helper('simipromoteapp/content')->getRegisterContent();

    $subscriber_subject = Mage::helper('simipromoteapp/content')->getSubscriberSubject();
    $subscriber_content = Mage::helper('simipromoteapp/content')->getSubscriberContent();

    $cms_content = Mage::helper('simipromoteapp/content')->getCMSContent();

    $installer->run("

      DROP TABLE IF EXISTS {$this->getTable('simipromoteapp')};
      CREATE TABLE {$this->getTable('simipromoteapp')} (
        `simipromoteapp_id` int(11) unsigned NOT NULL auto_increment,
        `template_id` int(11) unsigned NOT NULL,
        `customer_name` varchar(255) NOT NULL default '',
        `customer_email` varchar(255) NOT NULL default '',
        `is_open` smallint(6) NOT NULL default '0',
        `created_time` datetime NULL,
        `update_time` datetime NULL,
        PRIMARY KEY (`simipromoteapp_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        INSERT INTO {$this->getTable('core_email_template')} (`template_code`, `template_text`, `template_type`, `template_subject`, `template_sender_name`, `template_sender_email`, `added_at`, `modified_at`) VALUES
          ('Email For Register', '$register_content', 1, '$register_subject', NULL, NULL, NOW(), NOW());

        INSERT INTO {$this->getTable('core_email_template')} (`template_code`, `template_text`, `template_type`, `template_subject`, `template_sender_name`, `template_sender_email`, `added_at`, `modified_at`) VALUES
          ('Email For Subscriber', '$subscriber_content', 1, '$subscriber_subject', NULL, NULL, NOW(), NOW());


        INSERT INTO {$this->getTable('core_email_template')} (`template_code`, `template_text`, `template_type`, `template_subject`, `template_sender_name`, `template_sender_email`, `added_at`, `modified_at`) VALUES
          ('Email For Purchasing Order', '$purchased_content', 1, '$purchased_subject', NULL, NULL, NOW(), NOW());
    ");

    Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
    $cmsPage = array(
      'title' => 'Mobile Application',
      'identifier' => 'mobile-application.html',
      'content' => $cms_content,
      'is_active' => 1,
      'sort_order' => 0,
      'stores' => array(0),
      'root_template' => 'empty',
      'layout_update_xml' => '<reference name="head"><action method="addCss"><stylesheet>css/langdingpage.css</stylesheet></action></reference>',
      'meta_keywords' => 'Mobile shopping application, android app, ios app',
      'meta_description' => 'Download app for Android and iOS to shop hundreds of products at your fingertips and never miss out the hottest products & best deals. Download now!',
    );
    $cms = Mage::getModel('cms/page');
    $cms->setData($cmsPage)->save();

    Mage::getModel('core/config')->saveConfig('simipromoteapp/cms/cms_promote_id', $cms->getId());

$installer->endSetup(); 