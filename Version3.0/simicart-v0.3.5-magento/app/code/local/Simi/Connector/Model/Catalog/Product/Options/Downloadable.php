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
 * Connector Model
 * 
 * @category    
 * @package     Connector
 * @author      Developer
 */
class Simi_Connector_Model_Catalog_Product_Options_Downloadable extends Simi_Connector_Model_Abstract
{


  public function getCollectionItems(){
        $session = Mage::getSingleton('customer/session');
        $purchased = Mage::getResourceModel('downloadable/link_purchased_collection')
            ->addFieldToFilter('customer_id', $session->getCustomerId())
            ->addOrder('created_at', 'desc');

        $this->setPurchased($purchased);
        $purchasedIds = array();
        foreach ($purchased as $_item) {
            $purchasedIds[] = $_item->getId();
        }
        if (empty($purchasedIds)) {
            $purchasedIds = array(null);
        }

        $purchasedItems = Mage::getResourceModel('downloadable/link_purchased_item_collection')
            ->addFieldToFilter('purchased_id', array('in' => $purchasedIds))
            ->addFieldToFilter('status',
                array(
                    'nin' => array(
                        Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_PENDING_PAYMENT,
                        Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_PAYMENT_REVIEW
                    )
                )
            )
            ->setOrder('item_id', 'desc');
        return $purchasedItems;
    }

    public function getRemainingDownloads($item)
    {
        if ($item->getNumberOfDownloadsBought()) {
            $downloads = $item->getNumberOfDownloadsBought() - $item->getNumberOfDownloadsUsed();
            return $downloads;
        }
        return Mage::helper('downloadable')->__('Unlimited');
    }


      public function getDownloadUrl($item)
    {
        return Mage::getUrl('downloadable/download/link', array('id' => $item->getLinkHash(), '_secure' => true));
    }

   public function getItems() {
       $_items = $this->getCollectionItems();
       $data = array();
       if(count($_items)){
       		foreach ($_items as $_item){   
            $fileName = '';
            if($_item->getData('link_file')){ 
              $fileName = $_item->getData('link_file');     
              $fileName = explode('/', $fileName);
              $fileName = end($fileName);
            }
            $itDe = $this->getPurchased()->getItemById($_item->getPurchasedId());
	    		$data[] = array(
	    			'order_id' => $itDe->getOrderIncrementId(),
	    			'order_date' => $itDe->getCreatedAt(),
	    			'order_name' => $itDe->getProductName(),
            'order_link' => $this->getDownloadUrl($_item),
	    			'order_file' => $fileName,
	    			'order_status' => $_item->getStatus(),
	    			'order_remain' => Mage::helper('connector/downproduct')->getRemainingDownloads($_item)
	    			);
       		}	
       		$information = $this->statusSuccess();         
          $information['data'] = $data;
          return $information;
       }else{
       		$information = $this->statusError(array(Mage::helper('downloadable')->__('You have not purchased any downloadable products yet.')));
          return $information;
       }
       

   }

}
