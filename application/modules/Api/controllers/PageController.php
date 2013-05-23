<?php

//class Api_PageController extends Zend_Controller_Action
class Api_PageController extends Zend_Rest_Controller
{

    public function init()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
    }
    
    public function headAction()
    {
        //headaction
    }        

    public function indexAction()
    {
        //$this->getResponse()
        //        ->appendBody('indexAction() return');
        $modelPages= new Application_Model_Page();
        $pages = $modelPages->getAll();   
        //print_r($pages);
        
    }
    
    public function getAction()
    {
       $this->getResponse()
       ->appendBody('getAction() return');
       //$productModel = new Application_Model_Product();
       //$producten= $productModel->getAll();
       //var_dump($producten);
    }
    
    public function postAction()
    {
        $titel= $this->_getParam('titel');
        $omschrijving= $this->_getParam('omschrijving');
        
            try {
                $modelPages= new Application_Model_Page();
                $dbFields= array("Titel"=>$titel, "Omschrijving"=>$omschrijving);
                $modelPages->save($dbFields);   
            
            } catch (Exception $e) {
            //echo 'Caught exception: ',  $e->getMessage(), "\n";  
                return 500;
            }
            return 200;
       

    }
    
    public function putAction()
    {
        //$this->getResponse()
        // ->appendBody('putAction() return');
        $titel= $this->_getParam('titel');
        $omschrijving= $this->_getParam('omschrijving');
        $id= $this->_getParam('id');
        
        try {
                $modelPages= new Application_Model_Page();
                $dbFields= array("Titel"=>$titel, "Omschrijving"=>$omschrijving);
                $modelPages->save($dbFields,$id);   
            
            } catch (Exception $e) {
            //echo 'Caught exception: ',  $e->getMessage(), "\n";  
                return 500;
            }
            return 200;
    }
    
    public function deleteAction()
    {
        $this->getResponse()
                ->appendBody('deleteAction() return');
    }
 
    
    

    

}

