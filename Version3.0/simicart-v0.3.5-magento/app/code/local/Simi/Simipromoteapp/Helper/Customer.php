<?php

class Simi_Simipromoteapp_Helper_Customer extends Mage_Core_Helper_Abstract
{
    public function saveCustomerEmail($data){
        try{
            $model = Mage::getModel('simipromoteapp/simipromoteapp');
            $model->setData('customer_name',$data['name']);
            $model->setData('customer_email',$data['email']);
            $model->setData('template_id',$data['template_id']);
            $model->setData('is_open',Simi_Simipromoteapp_Model_Status::STATUS_DISABLED);
            $model->setData('created_time',now());
            $model->save();
        } catch (Exception $ex){

        }
    }

    public function getReportObj($email,$template_id){
        try{
            $report = Mage::getModel('simipromoteapp/simipromoteapp')->getCollection()
                        -> addFieldToFilter('template_id',$template_id)
                        -> addFieldToFilter('customer_email',$email)
                        -> getFirstItem();

            if($report->getId())
                return $report;
            else
                return null;
        } catch (Exception $ex){
            return null;
        }
    }
}