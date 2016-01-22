<?php

class Simi_Simipromoteapp_ReportController extends Mage_Core_Controller_Front_Action
{
	public function reportAction(){
		$customer_email = $this->getRequest()->getParam('email');
		$template_id = $this->getRequest()->getParam('template_id');

		// get report object
		if($customer_email != null && $template_id != null){
			$report = Mage::helper('simipromoteapp/customer')->getReportObj($customer_email,$template_id);
			if($report != null){
				$report->setData('is_open',Simi_Simipromoteapp_Model_Status::STATUS_ENABLED);
				$report->setData('update_time',now());
				$report->save();
			}
		}

	}

}