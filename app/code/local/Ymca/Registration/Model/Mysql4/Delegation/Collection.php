<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jrsa
 * Date: 2/26/14
 * Time: 5:36 AM
 * To change this template use File | Settings | File Templates.
 */ 
class Ymca_Registration_Model_Mysql4_Delegation_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('registration/delegation');
    }

}