<?php
/**
 * Created by PhpStorm.
 * User: trueplus
 * Date: 10/2/15
 * Time: 1:46 PM
 */

class Simi_Simipromoteapp_Helper_Email extends Mage_Core_Helper_Abstract
{
    const XML_SENDER_NAME = 'email/sender_name_identity';
    const XML_SENDER_EMAIL = 'email/sender_email_identity';
    const XML_EMAIL_REGISTER_TEMPLATE = 'email/email_for_register_template';
    const XML_EMAIL_SUBSCRIBER_TEMPLATE = 'email/email_for_subscriber_template';
    const XML_EMAIL_PURCHASING_TEMPLATE = 'email/email_for_purchasing_template';
    const XML_EMAIL_ENABLE = 'email/enable';
    const XML_IOS_LINK = 'app/ios_link';
    const XML_ANDROID_LINK = 'app/android_link';
    const XML_IMAGE_FIRST_BLOCK = 'cms/section_image_first_block';
    const XML_IMAGE_SECOND_BLOCK = 'cms/section_image_second_block';
    const XML_IMAGE_SMALL_THIRD_BLOCK = 'cms/section_image_small_third_block';
    const XML_IMAGE_LARGE_THIRD_BLOCK = 'cms/section_image_large_third_block';
    const XML_IMAGE_FOURTH_BLOCK = 'cms/section_image_fourth_block';
    const XML_CMS_PROMOTE_ID = 'cms/cms_promote_id';

    public function isEnable($store = null) {
        return $this->getHelperData()->getConfig(self::XML_EMAIL_ENABLE);
    }

    public function getHelperData(){
        return Mage::helper('simipromoteapp');
    }

    public function getTemplateEmailId($type){
        if($type == Simi_Simipromoteapp_Model_Status::TYPE_REGISTER)
            return $this->getHelperData()->getConfig(self::XML_EMAIL_REGISTER_TEMPLATE);
        else if($type == Simi_Simipromoteapp_Model_Status::TYPE_PURCHASING)
            return $this->getHelperData()->getConfig(self::XML_EMAIL_PURCHASING_TEMPLATE);
        else if($type == Simi_Simipromoteapp_Model_Status::TYPE_SUBSCRIBER)
            return $this->getHelperData()->getConfig(self::XML_EMAIL_SUBSCRIBER_TEMPLATE);
        else
            return null;
    }

    public function getSenderName(){
        return $this->getHelperData()->getConfig(self::XML_SENDER_NAME);
    }

    public function getSenderEmail(){
        return $this->getHelperData()->getConfig(self::XML_SENDER_EMAIL);
    }

    public function getiOsLink(){
        return $this->getHelperData()->getConfig(self::XML_IOS_LINK);
    }

    public function getAndroidLink(){
        return $this->getHelperData()->getConfig(self::XML_ANDROID_LINK);
    }

    public function getLogLink($email, $template_id){
        return Mage::getUrl('simipromoteapp/report/report',array('email'=>$email,'template_id'=>$template_id));
    }

    /**
     * send email
     * senderInfo = array('name'=>'','email'=>'');
     * variables = array(''=>'');
     **/
    public function sendEmail($data, $type)
    {
        // get template id
        $templateId = $this->getTemplateEmailId($type);
        $iOs_link = $this->getiOsLink();
        $android_link = $this->getAndroidLink();
        $email_sender = $this->getSenderEmail();

        if($templateId == null || ($iOs_link == null && $android_link == null) || $email_sender == null || filter_var($email_sender, FILTER_VALIDATE_EMAIL) === false){
            // can not send email

        } else {
            // prepare variables for email
            $variables = array(
                'customer_name' => $data['name'],
                'customer_email' => $data['email'],
                'ios_link' => $iOs_link,
                'android_link' => $android_link,
                'log_link' => $this->getLogLink($data['email'], $templateId)
            );

            // recipient
            $recipient_name = $data['name'];
            $recipient_email = $data['email'];

            // sender information
            $senderInfo = array(
                'name' => $this->getSenderName(),
                'email' => $email_sender,
            );

            // send transaction email
            $translate = Mage::getSingleton('core/translate');
            $translate->setTranslateInline(false);

            $storeId = Mage::app()->getStore()->getId();
            $store = Mage::app()->getStore();
            $config = array(
                'area' => 'frontend',
                'store' => $store->getId()
            );

            Mage::getModel('core/email_template')->setDesignConfig($config)
                ->sendTransactional($templateId, $senderInfo, $recipient_email, $recipient_name, $variables, $storeId);

            $translate->setTranslateInline(true);

            // insert customer email
            $data['template_id'] = $templateId;
            Mage::helper('simipromoteapp/customer')->saveCustomerEmail($data);
        }
    }
}