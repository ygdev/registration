<?php
class Ymca_Registration_Model_Convert_Adaptor_Advisor extends Mage_Dataflow_Model_Convert_Adapter_Abstract {

    public function load() {

    }

    public function save() {

    }

    public function saveRow(array $importData) {

        $model = Mage::getModel('registration/advisor');
    }
}