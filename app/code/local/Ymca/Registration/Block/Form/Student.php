<?php
class Ymca_Registration_Block_Form_Student extends Ymca_Registration_Block_Student {

    protected function _construct() {

        $this->setTemplate('registration/student.edit.phtml');
    }

    protected function _getYouthSummitValue() {

        return $this->getYouthSummit() ? "Yes" : "No";
    }
    protected function _getLegislativeWeekendValue() {

        return $this->getLegislativeWeekend() ? "Yes" : "No";
    }
    protected function _selected($key, $value) {

        if($this->_getCurrentStudent()->getData($key)==$value) {

            return "selected";
        }
    }
}