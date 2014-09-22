<?php
class Ymca_Registration_Model_Student extends Mage_Core_Model_Abstract {

    const DELEGATION_MODEL = 'registration/delegation';
    const BILL_MODEL = 'bill/bill';

    /* @var $_bill Ymca_Bill_Model_Bill
       @var $_delegation Ymca_Registration_Model_Delegation */
    protected $_delegation, $_bill;

    protected function _construct() {

        $this->_init('registration/student');
    }

    protected function _getDelegation() {

        if(!$this->_delegation) {
            $this->_delegation = Mage::getModel(self::DELEGATION_MODEL)->load($this->getData('delegation_id'));
        }
        return $this->_delegation;
    }

    public function getDelegationName() {

        return $this->_getDelegation()->getData('name');
    }

    public function getBill() {
        if(!$this->_bill) {

            $this->_bill = Mage::getModel('bill/bill')->load($this->getData('bill_id'));
        }
        return $this->_bill;
    }

    public function getCode() {

        return $this->getData('code');
    }

    public function getName() {

        return $this->getData('first_name').' '.$this->getData('last_name');
    }

    public function setGender($g) {

        if($g=='m') {

            $this->setData('gender', 'm');
            return;
        }
        elseif($g=='f') {

            $this->setData('gender', 'f');
            return;
        }
        throw new Exception('bad gender value: '.$g);
    }

    public function isRegisteredForLegislativeWeekend() {

        return (boolean)$this->getData('legislative_weekend');
    }

    public function isRegisteredForYouthSummit() {

        return (boolean)$this->getData('youth_summit');
    }
}