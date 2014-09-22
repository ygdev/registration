<?php
class Ymca_Bill_IndexController extends Mage_Core_Controller_Front_Action {

    const BILL_MODEL = 'bill/bill';
    const STUDENT_MODEL = 'registration/student';

    protected $_bill = null;

    protected function _getBill() {

        if(!isset($this->_bill)) {
            $this->_bill = Mage::getModel(self::BILL_MODEL);
        }
        return $this->_bill;
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

    public function viewAction() {

        $id = $this->getRequest()->getParam('id');

        if(!$id) {
            $this->_redirect('*/*/all');
        }

        $bill = $this->_getBill()->load($id);

        if(!$bill->getId()) {
            $this->_redirect('*/*/all');
        }

        $students = Mage::getModel('registration/student')->getCollection();
        $student=null;

        foreach($students as $s) {
            if($s->getBillId()==$id) {
                $student = $s;
            }
        }

        $delegation = Mage::getModel('registration/delegation')->load($student->getDelegationId());

        Mage::register(Ymca_Registration_Helper_Data::CURRENT_DELEGATION_KEY, $delegation);
        Mage::register(Ymca_Registration_Helper_Data::CURRENT_STUDENT_KEY, $student);
        Mage::register(Ymca_Bill_Helper_Data::CURRENT_BILL_KEY, $bill);

        $this->loadLayout();
        $this->renderLayout();
    }

    public function allAction() {

        $bills = $this->_getBill()->getCollection();



        $this->loadLayout();
        $this->renderLayout();
    }

    public function submitAction() {

        $studentId = $this->getRequest()->getParam('student_id');

        if($studentId) {

            Mage::register(Ymca_Bill_Helper_Data::CURRENT_STUDENT_ID_KEY, $studentId);
        }

        $this->loadLayout();
        $this->_title('Submit A Bill');
        $this->renderLayout();
    }

    public function submitPostAction() {

        $bill = $this->_getBill();

        $studentId = $this->getRequest()->getParam('student_id');
        $session = Mage::getSingleton('core/session');

        $student = Mage::getModel('registration/student')->load($studentId);

        if(!$student->getId()) {

            throw new Exception('Invalid Student!');
        }

        $errors=array();

        $name = $this->getRequest()->getParam('bill_name');
        $bill->setBillName($name);

        $number = $this->getRequest()->getParam('bill_number');
        $bill->setBillNumber($number);

        $content = $this->getRequest()->getParam('content');
        $bill->setContent($content);

        $bill->save();

        $id = $bill->getId();

        if(!$id) {

            // TODO: remove exception

            throw new Exception('error saving bill');

            // $session->addError('Error Saving Bill!');
            // $this->_redirect('*/*/submit');
        }

        $student->setData('bill_id', $id);
        $student->save();

        echo 'bill and student saved!';

        $this->_redirect('*/*/view', array('id'=>$id));
    }

    public function deleteAction() {

        $this->loadLayout();
        $this->renderLayout();
    }

    public function deletePostAction() {

        $id = $this->getParam('id');
        $bill = $this->_getBill()->load($id);
        $bill->delete();
    }
}
