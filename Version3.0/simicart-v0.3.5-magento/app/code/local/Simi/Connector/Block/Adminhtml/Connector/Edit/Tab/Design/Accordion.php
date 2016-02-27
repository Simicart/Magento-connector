<?php
/**
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    
 * @package     Connector
 * @copyright   Copyright (c) 2012 
 * @license     
 */

/**
 * Connector Edit Form Content Tab Block
 * 
 * @category 	
 * @package 	Connector
 * @author  	Developer
 */
class Simi_Connector_Block_Adminhtml_Connector_Edit_Tab_Design_Accordion extends Mage_Adminhtml_Block_Widget_Accordion {

    public function addAccordionItem($itemId, $block) {
        if (strpos($block, '/') !== false) {
            $block = $this->getLayout()->createBlock($block);
        } else {
            $block = $this->getLayout()->getBlock($block);
        }

        $this->addItem($itemId, array(
            'title' => $block->getTitle(),
            'content' => $block->toHtml(),
            'open' => $block->getIsOpen(),
        ));
    }

}
