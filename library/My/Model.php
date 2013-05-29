<?php

abstract class My_Model extends Zend_Db_Table_Abstract
{

    protected $errors = array();    
    public $db;    
    
 // -----------------------------------------
    public function init()
    {
    	$this->db = $this->getAdapter();    	
    }




    public function __construct($config = array())
    {
        parent::__construct($config);
    }    
    



 // -------------------------
 // CRUD
    public function getOne($id,$colName = 'id')
    {
        $row = parent::fetchRow('id = ' .(int)$id);            
        if (!$row) {
            return FALSE; 
        }
        return $row->toArray();
    }

    public function getRecordcount($where = null)
    {
        $data = $this->fetchAll($where)->count();
        return $data;
    }

    public function getOneByField($fieldName,$fieldValue){
    	$row = parent::fetchRow($fieldName .' = ' .$this->db->quote($fieldValue));            
        if (!$row) {
            return FALSE; 
        }
        return $row->toArray();    	
    }
    
    public function getOneByFields(array $fields,$operator = 'AND'){
    	$where = '0 = 0'; //dummy
    	foreach($fields as $k=>$v){
    		$where .= ' '. $operator . ' ' . $k . '=' . $this->db->quote($v);
    	}
    	$row = parent::fetchRow($where);            
        if (!$row) {
            return FALSE; 
        }
        return $row->toArray();    	
    }    
    
    public function getAll($where=null,$order=null)
    {
    	$data = $this->fetchAll($where,$order);
        return $data->toArray();
    }    


    /**
     * 
     * Delete by id
     * @param mixed array|integer $id
     * @param string $primaryKey : name of primary key, default id specified in model
     */
    public function deleteById($id,$primaryKey = '')
    {
       $primaryKey = !empty($primaryKey) ? $primaryKey : $this->_id;
       if (!is_array($id)){
       		$id = array((int)$id);       	
       }
       if (empty($id)){
       		return FALSE;
       }
       parent::delete($primaryKey . ' IN (' . implode(',',$id) . ')');
      // parent::delete('id =' . (int)$id);
    }

    public function updateById($id,$primaryKey = '', $data)
    {
       $primaryKey = !empty($primaryKey) ? $primaryKey : $this->_id;
       if (!is_array($id)){
       		$id = array((int)$id);
       }
       if (empty($id)){
       		return FALSE;
       }
       parent::update($data, $primaryKey . ' IN (' . implode(',',$id) . ')');
      // parent::delete('id =' . (int)$id);
    }

    public function buildSelect($options = NULL, $where= NULL, $order=NULL){
    	$defaultOptions = array(
    		'key'      => $this->_id,
    		'value'    => 'Omschrijving',
    		'emptyRow' => TRUE,
    	);
   		$options = !empty($options) && is_array($options) ? array_merge($defaultOptions,(array)$options) : $defaultOptions;
    	$data = $this->getAll($where,$order);
    	if (empty($data)){
    		return array();
    	}
    	$returnData = array();
    	if ($options['emptyRow']){
    		$returnData[''] = '';
    	}
    	foreach($data as $row){
    		$returnData[$row[$options['key']]] = $row[$options['value']];
    	}    	
    	return $returnData;
    }   
    
    public function buildSelectFromArray($data = array(),$options = NULL){
    	$defaultOptions = array(
    		'key'      => $this->_id,
    		'value'    => 'Omschrijving',
    		'emptyRow' => TRUE,
    	);
   		$options = !empty($options) && is_array($options) ? array_merge($defaultOptions,(array)$options) : $defaultOptions;
    	//$data = $this->getAll();
    	if (empty($data)){
    		return array();
    	}
    	$returnData = array();
    	if ($options['emptyRow']){
    		$returnData[''] = '';
    	}
    	foreach($data as $row){
    		$returnData[$row[$options['key']]] = $row[$options['value']];
    	}    	
    	return $returnData;
    }      
  	
 // -------------------------   
    public function getTable()
    {    
    	return $this->_name;
    }
 
    public function fetchSearchResults($keyword)
    {
        $result = $this->getTable()->fetchSearchResults($keyword);
        return $result;
    } 



}
