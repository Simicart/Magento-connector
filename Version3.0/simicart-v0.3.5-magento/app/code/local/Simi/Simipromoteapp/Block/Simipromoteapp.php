<?php

class Simi_Simipromoteapp_Block_Simipromoteapp extends Mage_Core_Block_Template
{
	public function _prepareLayout(){
		
		return parent::_prepareLayout();
	}

	public function getHelperData(){
		return Mage::helper('simipromoteapp');
	}

	public function getType(){
		return $this->getData('type');
	}

	public function getImageFirstBlock(){
		return $this->getHelperData()->getConfig(Simi_Simipromoteapp_Helper_Email::XML_IMAGE_FIRST_BLOCK);
	}

	public function getImageSecondBlock(){
		return $this->getHelperData()->getConfig(Simi_Simipromoteapp_Helper_Email::XML_IMAGE_SECOND_BLOCK);
	}

	public function getImageSmallThirdBlock(){
		return $this->getHelperData()->getConfig(Simi_Simipromoteapp_Helper_Email::XML_IMAGE_SMALL_THIRD_BLOCK);
	}

	public function getImageLargeThirdBlock(){
		return $this->getHelperData()->getConfig(Simi_Simipromoteapp_Helper_Email::XML_IMAGE_LARGE_THIRD_BLOCK);
	}

	public function getImageFourthBlock(){
		return $this->getHelperData()->getConfig(Simi_Simipromoteapp_Helper_Email::XML_IMAGE_FOURTH_BLOCK);
	}
}