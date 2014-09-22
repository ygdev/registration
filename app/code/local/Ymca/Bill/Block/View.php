<?php
class Ymca_Bill_Block_View extends Mage_Core_Block_Template {

    /* @var $_bill Ymca_Bill_Model_Bill */
    protected $_bill;

    protected function _construct() {

        $this->setTemplate('bill/view.phtml');
    }

    protected function _getBill() {

        return Mage::helper('bill')->getCurrentBill();
    }

    protected function getBillName() {

        return $this->_getBill()->getBillName();
    }

    protected function getNumber() {

        return $this->_getBill()->getBillNumber();
    }
    protected function getBody() {

        return $this->_getBill()->getContent();
    }
    protected function getDelegateName() {

        /* @var $help Ymca_Registration_Helper_Data */
        return Mage::helper('registration')->getStudent()->getName();
    }
    protected function getDelegateLink() {

        return Mage::getUrl('reg/index/view', array('id'=>Mage::helper('registration')->getStudent()->getId()));
    }
    protected function getDelegationName() {

        /* @var $help Ymca_Registration_Helper_Data */
        return Mage::helper('registration')->getDelegation()->getName();
    }

}