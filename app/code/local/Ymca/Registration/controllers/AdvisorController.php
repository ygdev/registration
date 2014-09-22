<?php
class Ymca_Registration_AdvisorController extends Mage_Core_Controller_Front_Action {

    const ADVISOR_SESSION_MODEL = 'registration/advisor_session';


    protected function _getSession() {

        /* @var $s Ymca_Registration_Model_Advisor_Session */
        $s = Mage::getSingleton(self::ADVISOR_SESSION_MODEL);
        return $s;
    }

    public function indexAction() {

        if($this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/index/all');
        }
        else {
            $this->_redirect('*/*/login');
        }
    }

    public function loginAction() {

        if($this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/index/all');
        }

        $this->loadLayout();
        $this->_initLayoutMessages('core/session');
        $this->renderLayout();
    }

    public function loginPostAction() {

        if($this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/index/all');
        }

        if($this->getRequest()->isPost()) {

            $post = $this->getRequest()->getPost();

            if(empty($post['username']) || empty($post['password'])) {
                Mage::getSingleton('core/session')->addError('Username and Password Required');
                $this->_redirect('*/*/login');
            }

            $this->_getSession()->login($post['username'], $post['password']);

            $this->_redirect('*/index/all');
        }

    }

    public function logoutAction() {

        Mage::getSingleton('registration/advisor_session')->logout();
        $this->_redirect('*/*/login');
    }
}