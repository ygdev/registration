<?php
class Ymca_Registration_Block_Delegation extends Mage_Core_Block_Template {

    protected static $_values = array(-1 => "No", 0 => "Unknown", 1 => "Yes");
    protected static $_CssClasses = array(-1 => "danger", 0 => "default", 1 => "success");

    protected function getValue($idx) {
        return self::$_values[$idx];
    }

    protected function getCssClasses($idx) {
        return self::$_CssClasses[$idx];
    }

    protected function _construct() {

        $this->setTemplate('registration/delegation.phtml');
    }

    protected function _getStudents() {

        return Mage::helper('registration')->getStudentCollection();
    }

    protected function getDelegationName() {

         return Mage::helper('registration')->getDelegation()->getName();
    }

    protected function getBillCell($student) {

        /* @var $bill Ymca_Bill_Model_Bill
         * @var $student Ymca_Registration_Model Student */
        $bill = $student->getBill();
        $id = $bill->getId();

        $url = (bool)$id ? Mage::getUrl('bills/index/view', array('id'=>$id)) : "";

        if($id) {
            return "<a href=\"{$url}\"><span class=\"label label-success\">View Bill</span></a>";
        }
        else {
            return "<span class=\"label label-danger\">No</span>";
        }
    }
}