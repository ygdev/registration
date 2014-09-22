<?php
class Ymca_Registration_Model_Mysql4_Advisor extends Mage_Core_Model_Mysql4_Abstract {

    protected function _construct() {

        $this->_init('registration/advisors', 'advisor_id');
    }
}