<?php

class Simi_Simipromoteapp_Helper_Chart extends Mage_Core_Helper_Abstract
{
    const PATH_TEXT_BY_APP = 'chart/by_app';
    const PATH_TEXT_BY_WEBSITE = 'chart/by_website';
    const PATH_CHART_TITLE = 'chart/chart_title';
    const PATH_PERCENT = 'chart/percent';
    const PATH_CHART_ENABLE = 'chart/enable';


    public function getHelperData(){
        return Mage::helper('simipromoteapp');
    }

    public function isEnable() {
        return $this->getHelperData()->getConfig(self::PATH_CHART_ENABLE);
    }

    public function getTextByApp(){
        return $this->getHelperData()->getConfig(self::PATH_TEXT_BY_APP);
    }

    public function getTextByWebsite(){
        return $this->getHelperData()->getConfig(self::PATH_TEXT_BY_WEBSITE);
    }

    public function getChartTitle(){
        return $this->getHelperData()->getConfig(self::PATH_CHART_TITLE);
    }

    public function getPercent(){
        return $this->getHelperData()->getConfig(self::PATH_PERCENT);
    }
}