<?php

class Application_Model_Page extends My_Model
{
    protected $_name = "pages";
    protected $_primary = "ID";
    
   
    public function save($data,$id = NULL)
    {
    	//ini
    	//$currentTime =  date("Y-m-d H:i:s", time());

        $isUpdate = FALSE;
        $dbFields = array(     	
                'Titel'                => $data['Titel'],
                'Omschrijving'         => $data['Omschrijving'],
        );
        
        if (!empty($id)) {
        	$isUpdate = TRUE;
        	$this->update($dbFields,$id);               
                return $id;
        }
        
        //$dbFields['creationDate'] = $currentTime;

        return $this->insert($dbFields);        
    }
    
    
        
}

