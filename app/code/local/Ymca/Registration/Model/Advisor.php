<?php
class Ymca_Registration_Model_Advisor extends Mage_Core_Model_Abstract {

    protected function _construct() {

        $this->_init('registration/advisor');
    }

    public function loadByUsername($username) {

        $bind = array('advisor_username'=>$username);
        $res = $this->_getResource();

        $select = $res->getReadConnection()->select()
            ->from($res->getMainTable(), $res->getIdFieldName())
            ->where('username = :advisor_username');


        $id = $res->getReadConnection()->fetchOne($select,$bind);

        if($id) {
            $this->load($id);
        }
    }
}