<?php

require_once 'abstract.php';

class Jrsa_Dataflow_RunProfile extends Mage_Shell_Abstract {

    public function run() {

        Mage::app('admin');

        $profile = Mage::getModel('dataflow/profile');
        $user = Mage::getModel('admin/user');

        $user->setUserId(0);
        Mage::getSingleton('admin/session')->setUser($user);

        $id = $this->getArg('id');
        $profile->load($id);
        if(!$profile->getId()) {
            Mage::getSingleton('admin/session')->addError("profile {$id} not found");
        }

        Mage::register('current_convert_profile', $profile);
        $profile->run();
    }
}

$script = new Jrsa_Dataflow_RunProfile();
$script->run();