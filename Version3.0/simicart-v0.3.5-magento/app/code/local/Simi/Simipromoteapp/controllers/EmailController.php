<?php

class Simi_Simipromoteapp_EmailController extends Mage_Core_Controller_Front_Action
{
	public function reportAction(){
		$from_date = $this->getRequest()->getParam('from_date');
		$to_date = $this->getRequest()->getParam('to_date');

		$data = array(
			'from' => $from_date,
			'to' => $to_date,
		);

		$output = array();
		$data_highchart = Mage::helper('simipromoteapp/report')->reportEmail($data);

		$categories = '';
		$sent_highchart = '';
		$open_highchart = '';
		$count = sizeof($data_highchart);
		$is_last = 0;
		foreach ($data_highchart as $highchart) {
			if($is_last == ($count - 1)){
				$categories .= date('d',strtotime($highchart['current_date']));
				$open_highchart .= $highchart['open_rate'];
				$sent_highchart .= $highchart['total_sent'];
			}
			else {
				$categories .= date('d', strtotime($highchart['current_date'])) . ',';
				$open_highchart .= $highchart['open_rate'] . ',';
				$sent_highchart .= $highchart['total_sent'] . ',';
			}
			$is_last++;
		}

		$output['categories'] = $categories;
		$output['open_highchart'] = $open_highchart;
		$output['sent_highchart'] = $sent_highchart;

		$json = json_encode($output);

		$this	->getResponse()
				->clearHeaders()
				->setHeader('Content-Type', 'application/json')
				->setBody($json);
	}

}