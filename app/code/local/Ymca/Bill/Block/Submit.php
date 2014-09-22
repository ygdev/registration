<?php
class Ymca_Bill_Block_Submit extends Mage_Core_Block_Template {

    protected function _construct() {

        $this->setTemplate('bill/submit.phtml');
    }

    protected function _getStudents() {

        return Mage::helper('bill')->getStudents();
    }
}