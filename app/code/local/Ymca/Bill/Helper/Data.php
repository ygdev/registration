<?php
class Ymca_Bill_Helper_Data extends Mage_Core_Helper_Abstract {

    const CURRENT_STUDENT_ID_KEY = 'current_student_id';
    const CURRENT_DELEGATION_ID_KEY = 'current_delegation_id';

    const CURRENT_BILL_KEY = 'current_bill';
    const BILl_COLLECTION_KEY = 'bill_collection';

    const STUDENT_MODEL = 'registration/student';
    const BILL_MODEL = 'bill/bill';

    public function getStudents() {

        /* @var $advisorSession Ymca_Registration_Model_Advisor_Session */
        $delegationId = Mage::getSingleton('registration/advisor_session')->getAdvisor()->getDelegationId();

        return Mage::getModel(self::STUDENT_MODEL)->getCollection()->addFieldToFilter('delegation_id', $delegationId);
    }

    public function getCurrentBill() {

        return Mage::registry(self::CURRENT_BILL_KEY);
    }
}