<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $modelPages= new Application_Model_Page();
        $this->view->pages = $modelPages->getAll();        
    }
    
    
       


}

