<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $id=$this->_getParam('id');
        $modelPages= new Application_Model_Page(null,"Titel");
        $this->view->pages = $modelPages->getAll();
        $this->view->id=$id;
    }

    public function apiclientAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $client = new Zend_Http_Client();
        $post = array('titel' => 'Pagina3', 'omschrijving' => 'Dit is pagina3.');
        $client->setUri('http://local.pageapi/Api/page/');
        $client->setParameterPost($post);
        $response = $client->request('POST');
        var_dump($response);exit;

   }




}

