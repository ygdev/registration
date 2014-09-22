<?php
class Ymca_Registration_Model_Advisor_Session extends Mage_Core_Model_Session_Abstract {

    const ADVISOR_MODEL = 'registration/advisor';

    protected $_advisor;

    protected function _construct() {

        $this->init('advisor');
    }

    public function authenticate(Mage_Core_Controller_Front_Action $action) {

        if($this->isLoggedIn()) {
            return true;
        }
        else {
            $action->getResponse()->setRedirect(Mage::getUrl('reg/advisor/login'));
        }
    }

    public function login($user, $pass) {

        /* @var $advisor Ymca_Registration_Model_Advisor */
        $advisor = Mage::getModel(self::ADVISOR_MODEL);
        $advisor->loadByUsername($user);

        $pwData = $advisor->getData('password');

        if(!($pwData ===$pass)) {

            return false;
        }

        $this->setAdvisor($advisor);

        return true;
    }

    public function logout() {

        $this->setId(null); // no longer tied to an advisor entry
        $this->getCookie()->delete($this->getSessionName());
        return $this;
    }

    public function isLoggedIn() {

        $advisor = $this->getAdvisor();
        if($advisor) {
            return (bool)$advisor->getId();
        }
        else {
            return false;
        }
    }

    public function getAdvisor() {

        // the cached value, if it exists
        if($this->_advisor instanceof Ymca_Registration_Model_Advisor) {
            return $this->_advisor;
        }
        /* @var $advisor Ymca_Registration_Model_Advisor */
        // new instance
        $advisor = Mage::getModel(self::ADVISOR_MODEL);

        // id is stored in session, use it to instance the model for this request
        if($this->getId()) {
            $advisor->load($this->getId());
        }

        // if this is the first get, use the setter to initialize lol
        $this->setAdvisor($advisor);
        return $this->_advisor;
    }
    public function setAdvisor(Ymca_Registration_Model_Advisor $advisor) {

        $this->_advisor = $advisor;
        $this->setId($this->_advisor->getId());
        return $this;
    }
}