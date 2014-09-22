<?php
class Ymca_Registration_Model_Mysql4_Student_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    protected function _construct() {

        $this->_init('registration/student');
    }
}