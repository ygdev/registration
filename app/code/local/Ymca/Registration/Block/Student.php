<?php
class Ymca_Registration_Block_Student extends Mage_Core_Block_Template {

    protected static $_values = array(-1 => "No", 0 => "Unknown", 1 => "Yes");
    protected static $_CssClasses = array(-1 => "danger", 0 => "default", 1 => "success");

    /* @var $_currentStudent Ymca_Registration_Model_Student */
    protected $_currentStudent;

    protected function _construct() {

        $this->setTemplate('registration/student.phtml');
    }

    protected static function _getValue($idx) {
        return self::$_values[$idx];
    }

    protected static function getCssClasses($idx) {
        return self::$_CssClasses[$idx];
    }

    protected function _getCurrentStudent() {

        if(!isset($this->_currentStudent)) {
            $this->_currentStudent = Mage::helper('registration')->getStudent();
        }
        return $this->_currentStudent;
    }

    protected function getName() {

        return $this->_getCurrentStudent()->getName();
    }
    public function getFirstName() {

        return $this->_getCurrentStudent()->getFirstName();
    }
    public function getLastName() {

        return $this->_getCurrentStudent()->getLastName();
    }

    protected function getDelegation() {

        return $this->_getCurrentStudent()->getDelegationName();
    }

    protected function getGrade() {

        return $this->_getCurrentStudent()->getGrade();
    }
    protected function getYears() {

        return $this->_getCurrentStudent()->getYears();
    }
    protected function getEthnicity() {

        return $this->_getCurrentStudent()->getEthnicity();
    }
    protected function getCode() {

        return $this->_getCurrentStudent()->getCode();
    }
    protected function getStudentId() {

        return $this->_getCurrentStudent()->getId();
    }

    protected function getLegislativeWeekend() {

        return $this->_getValue($this->_getCurrentStudent()->getData('legislative_weekend'));
    }

    protected function getLegislativeWeekendCssClass() {

        return $this->getCssClasses($this->_getCurrentStudent()->getData('legislative_weekend'));
    }

    protected function getYouthSummit() {

        return $this->_getValue($this->_getCurrentStudent()->getData('youth_summit'));
    }

    protected function getYouthSummitCssClass() {

        return $this->getCssClasses($this->_getCurrentStudent()->getData('youth_summit'));
    }

    // bill info
    protected function hasBill() {

        return (boolean)$this->_getCurrentStudent()->getBill()->getData('bill_id');
    }

    protected function isBillSubmitted() {

        return $this->hasBill();

//        return (boolean)$this->_getCurrentStudent()->getBill()->getData('status');
    }
    protected function getBillNumber() {

        /* @var $bill Ymca_Bill_Model_Bill */
        $bill = $this->_getCurrentStudent()->getBill();
        return $bill->getData('bill_number');
    }
    protected function getBillId() {

        return $this->_getCurrentStudent()->getBill()->getId();
    }

    // emergency info

    protected function getEmergencyName() {

        return $this->_getCurrentStudent()->getEmergencyName();
    }
    protected function getEmergencyRelation() {

        return $this->_getCurrentStudent()->getEmergencyRelation();
    }
    protected function getEmergencyNumber() {

        return $this->_getCurrentStudent()->getEmergencyNumber();
    }

    // transportation
    protected function getToYouthSummit() {

        $value = (int)$this->_getCurrentStudent()->getData('to_youth_summit');

        $class = self::getCssClasses($value);
        $label = self::_getValue($value);

        return "<span class=\"label label-$class\">$label</span>";

    }
    protected function getFromYouthSummit() {

        $value = (int)$this->_getCurrentStudent()->getData('from_youth_summit');

        $class = self::getCssClasses($value);
        $label = self::_getValue($value);

        return "<span class=\"label label-$class\">$label</span>";
    }
    protected function getToLegislativeWeekend() {

        $value = (int)$this->_getCurrentStudent()->getData('to_legislative_weekend');

        $class = self::getCssClasses($value);
        $label = self::_getValue($value);

        return "<span class=\"label label-$class\">$label</span>";
    }
    protected function getFromLegislativeWeekend() {

        $value = (int)$this->_getCurrentStudent()->getData('from_legislative_weekend');

        $class = self::getCssClasses($value);
        $label = self::_getValue($value);

        return "<span class=\"label label-$class\">$label</span>";
    }

    protected function getBillCell() {

        $text = $this->hasBill()? "View Bill" : "No";
        $class = $this->hasBill()? "success" : "danger";
        return "<a href=\"".Mage::getUrl('bills/index/view', array('id'=>$this->getBillId()))."\"><span class=\"label label-".$class."\">".$text."</span></a>";
    }
}