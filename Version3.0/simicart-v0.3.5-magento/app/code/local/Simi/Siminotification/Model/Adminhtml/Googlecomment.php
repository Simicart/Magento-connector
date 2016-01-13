<?php
class Simi_Siminotification_Model_Adminhtml_Googlecomment
{
    public function getCommentText(){
        $comment = 'To register a Google Map API key, please follow the guide <a href="'.Mage::getBlockSingleton('adminhtml/widget')->getUrl('siminotificationadmin/adminhtml_siminotification/guide/', array('_secure'=>true)).'">here</a>';
        return $comment;
    }
}
