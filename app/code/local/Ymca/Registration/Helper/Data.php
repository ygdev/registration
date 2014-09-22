<?php
class Ymca_Registration_Helper_Data extends Mage_Core_Helper_Abstract {

    const CURRENT_STUDENT_KEY = 'current_student';
    const STUDENT_COLLECTION_KEY = 'student_collection';

    const CURRENT_DELEGATION_KEY = 'current_delegation';

    public function getStudent() {

        return Mage::registry(self::CURRENT_STUDENT_KEY);
    }

    public function getStudentCollection() {

        return Mage::registry(self::STUDENT_COLLECTION_KEY);
    }

    public function getDelegation() {

        return Mage::registry(self::CURRENT_DELEGATION_KEY);
    }
}