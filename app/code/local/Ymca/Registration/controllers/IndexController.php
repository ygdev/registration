<?php
class Ymca_Registration_IndexController extends Mage_Core_Controller_Front_Action {

    const STUDENT_MODEL_NAME = 'registration/student';
    const ADVISOR_MODEL_NAME = 'registration/advisor';

    private static $_formBlacklist = array('id', 'code', 'bill_id');

    protected $_advisor;
    protected $_session;

    protected function _getStudent() {

        return Mage::getModel(self::STUDENT_MODEL_NAME);
    }

    protected function _getSession() {

        if(!isset($this->_session)) {

            $this->_session = Mage::getSingleton('registration/advisor_session');
        }

        return $this->_session;
    }

    protected function _getAdvisor() {

        if(!isset($this->_advisor)) {

            // TODO: this will come from the session
            $this->_advisor = Mage::getModel(self::ADVISOR_MODEL_NAME);
        }
        return $this->_advisor;
    }

    protected function _getAdvisorSession() {

        /* @var $s Ymca_Registration_Model_Advisor_Session */
        $s = Mage::getSingleton('registration/advisor_session');
        return $s;
    }

    public function preDispatch() {

        parent::preDispatch();

        if (!$this->getRequest()->isDispatched()) {
            return;
        }

        if (!$this->_getAdvisorSession()->authenticate($this)) {
            $this->setFlag('', 'no-dispatch', true);
        }
    }
//
//    public function postDispatch()
//    {
//        parent::postDispatch();
//        $this->_getSession()->unsNoReferer(false);
//    }

    public function indexAction() {

        $this->_redirect('*/*/all');
    }

    public function viewAction() {

        //$this->_title($this->_getStudent()->getFirstName().' '.$this->getLastName());

        $this->loadLayout();
        $session = Mage::getSingleton('core/session');

        $id = $this->getRequest()->getParam('id');
        if(!$id) {
            $session->addError('Record Not Found');
        }

        Mage::register(Ymca_Registration_Helper_Data::CURRENT_STUDENT_KEY,
            $this->_getStudent()->load($id));

        $this->_initLayoutMessages('core/session');
        $this->renderLayout();
    }

    public function allAction() {


        $this->loadLayout();

        $session = $this->_getAdvisorSession();
        $delegationId = $session->getAdvisor()->getDelegationId();

        $delegation = Mage::getModel('registration/delegation')->load($delegationId);
        if(!$delegation->getId()) {
            throw new Exception('Delegation Id not set!');
        }

        $this->_title($delegation->getName());

        Mage::register(Ymca_Registration_Helper_Data::STUDENT_COLLECTION_KEY,
            $this->_getStudent()->getCollection()->addFieldToFilter('delegation_id', $delegationId));

        Mage::register(Ymca_Registration_Helper_Data::CURRENT_DELEGATION_KEY,
            Mage::getModel('registration/delegation')->load($delegationId));

        $this->renderLayout();
    }

    public function createAction() {

        $newStudent = $this->_getStudent();
        $newStudent->setData('delegation_id', $this->_getAdvisorSession()->getAdvisor()->getDelegationId());
        $newStudent->save();

        $id = $newStudent->getId();

        if($id) {
            $this->_redirect('*/*/edit', array('id'=>$id));
        }
        else {
            Mage::getSingleton('core/session')->addError('Error saving Student');
            $this->_redirect('*/*/all');
        }
    }

    public function editAction() {

        $this->_title('Edit Student Record');

        $id = $this->getRequest()->getParam('id');

        if(!$id) {
            $this->_redirect('noRoute');
        }

        $student = Mage::getModel(self::STUDENT_MODEL_NAME)->load($id);

        if(!$student->getId()) {
            $this->_redirect('noRoute');
        }

        Mage::register(Ymca_Registration_Helper_Data::CURRENT_STUDENT_KEY, $student);

        $this->loadLayout();
        $this->renderLayout();
    }

    public function editPostAction() {

        $student = $this->_getStudent();

        $params = $this->getRequest()->getPost();

        $student->load($params['id']);

        if(!$student->getId()) {
            throw new Exception('couldn\'t load student record');
        }

        $validParams = array_diff_key($params, array_flip(self::$_formBlacklist));

        foreach($validParams as $key=>$value) {

            $student->setData($key, $value);
        }

       $student->save();

        $this->_redirect('*/*/view', array('id'=>$student->getId()));

    }

    public function deleteAction() {

        $id = $this->getRequest()->getParam('id');

        if(!$id) {
            $this->_redirect('noRoute');
        }

        $student = Mage::getModel(self::STUDENT_MODEL_NAME)->load($id);

        if(!$student->getId()) {
            $this->_redirect('noRoute');
        }

        $student->delete();
        $this->_redirect('*/*/all');
    }
}