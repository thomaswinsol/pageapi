<?php
/**
 * Abstract controller
 * Provides listing, edit and delete functionality
 */
abstract class My_Controller_Action extends Zend_Controller_Action
{
    public $context;
    public $baseUrl;
    public $uurtarief=30;

    public function init()
    {
        $defaultNamespace = new Zend_Session_Namespace ();
        if(!array_key_exists('context2', $_SESSION))
        {
            $_SESSION['context2']=array('username'=>"",'user'=>"");
        }
        $this->context = $_SESSION ['context2'];
        $this->baseUrl = '/winplan/public';
        $this->view->baseUrl = $this->baseUrl;
    }    
   

    public function __destruct()
    {
        $this->SaveContext ();
    }

    public function SaveContext()
    {
        $_SESSION ['context2'] = $this->context;
    }

    public function IsAllowed($resource) {
        $registry = Zend_Registry::getInstance();
        $acl = $registry->get('Zend_Acl');
        if (!$acl->IsAllowed($this->context['userrole'],$resource )){
            return false;
        }
        return true;
    }
   
}
