<?php

class Simi_Siminotification_Adminhtml_Siminotification_HistoryController extends Mage_Adminhtml_Controller_Action
{
	/**
	 * init layout and set active for current menu
	 *
	 * @return Simi_Siminotification_Adminhtml_Deviceontroller
	 */
	protected function _initAction(){
		$this->loadLayout()
			->_setActiveMenu('siminotification/history')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Notification History Manager'), Mage::helper('adminhtml')->__('Notification History Manager'));
		return $this;
	}
 
	/**
	 * index action
	 */
	public function indexAction(){
		$this->_initAction()
			->renderLayout();
	}

	/**
	 * view and edit item action
	 */
	public function editAction() {
		$id	 = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('siminotification/history')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data))
				$model->setData($data);

			Mage::register('history_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('siminotification/history');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Notification History Manager'), Mage::helper('adminhtml')->__('Notification History Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Notification History News'), Mage::helper('adminhtml')->__('Notification History News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock('siminotification/adminhtml_history_edit'))
				->_addLeft($this->getLayout()->createBlock('siminotification/adminhtml_history_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('siminotification')->__('Notification history does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}

	/**
     * delete item action
     */
    public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('siminotification/history');
                $model->setId($this->getRequest()->getParam('id'))
                        ->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Notification history was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * mass delete item(s) action
     */
    public function massDeleteAction() {
        $notificationIds = $this->getRequest()->getParam('history');

        if (!is_array($notificationIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($notificationIds as $notificationId) {
                    $history = Mage::getModel('siminotification/history')->load($notificationId);
                    $history->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Total of %d notification(s) were successfully deleted', count($notificationIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
 
}