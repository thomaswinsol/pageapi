<?php

abstract class My_Model extends Zend_Db_Table_Abstract
{

    protected $errors = array();
    
    public $db;    
    protected $dealerGebruikerId;
    protected $dataGrid;
    protected $enableDataGrid = FALSE;
    protected $baseUrl = '/winplan/public';
    
 // -----------------------------------------
    public function init()
    {
    	$this->db = $this->getAdapter();
    	//$this->db->setFetchMode(Zend_Db::FETCH_ASSOC); //doesn't work  
        if ($this->enableDataGrid){
        	$dataGrid       = new My_DataGrid();
        	$this->dataGrid = $dataGrid->getGrid();
        }
        $this->dealerGebruikerId = 1;//to do: retrieve from session

    }




    public function __construct($config = array())
    {
        parent::__construct($config);
    }    
    
    /*public function insert($data)
    {
        //validation
    	//save
           // $data = array();
            parent::insert($data);
    }

    public function update($id, $data)
    {
        //$data = array();
        parent::update(array($data), 'id = '. (int)$id);
    }*/


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
    
    
    
    
    /**
     * Check on errors
     *
     * @return bool
     */
    public function hasErrors()
    {
        if (!empty($this->errors)) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Get errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set 1 error message
     *
     * @param string $msg
     */
    public function addError($msg)
    {
        if (!empty($msg)) {
            $this->errors = (string) $msg;
        }
    }

    /**
     * Set error messages
     *
     * @param array $msg
     */
    public function addErrors($msg)
    {
        if (!empty($msg) && is_array($msg)) {
            $this->errors = array_merge($this->errors, $msg);
        }
    }

    /**
     * Get navigation to first,previous,next,last record
     *
     * @param string $entityName name of entity
     * @param integer $id optional relative record
     * @param string $where optional, where clause
     *     example:
     *         array(
     *             'column' => 'postalCode',
     *             'value' => '2340',
     *         )
     *     example:
     *         array(
     *             'join' => 'customer',
     *             'column' => 'id',
     *             'value' => $customer->getId(),
     *         )
     * 
     * @return array
     */
    /*
    public function getRecordNavigation($entityName, $id = NULL, $options = NULL)
    {
        // camelcase entity name to dash separated
        $entity = '';
        for ($i = 0; $i < strlen($entityName); $i++) {
            if ($i > 0 && ctype_upper($entityName[$i])) {
                $entity .= '-';
            }
            $entity .= $entityName[$i];
        }
        $entity = strtolower($entity);

        // initiate navigation
        $navigation = array(
            'entity'   => $entity,
            'first'    => NULL,
            'previous' => NULL,
            'next'     => NULL,
            'last'     => NULL,
        );

        // intitialize where options
        $join = !empty($options['join']) ? ' join e.' . $options['join'] . ' as j' : '';
        $column = !empty($options['column']) ? $options['column'] : '';
        $value = !empty($options['value']) ? $options['value'] : '';
        if ($column !== '' && $value !== '') {
            $where = ' ' . ($join !== '' ? 'j.' : 'e.') . "$column = $value";
        }

        $sql = 'select min(e.id), max(e.id) from Entities\\' . $entityName . ' e ';
        $sql .= !empty($where)  ? $join . ' where ' . $where : '';

        $queryMinMax = $this->_em->createQuery($sql);
        $minMax = $queryMinMax->getResult();
        $navigation['first'] = $minMax[0]['1'];
        $navigation['last'] = $minMax[0]['2'];

        // if first and last are the same, disable navigation
        if ($navigation['first'] == $navigation['last']) {
            $navigation['first'] = NULL;
            $navigation['last'] = NULL;
            return $navigation;
        }

        $sql = 'select e.id from Entities\\' . $entityName . ' e ' . $join . ' where e.id < ?1';
        $sql .= !empty($where) ? ' and ' . $where : '';
        $sql .= ' order by e.id desc';
        $queryPrevious = $this->_em->createQuery($sql);
        $queryPrevious->setParameter(1, $id!==NULL?$id:$navigation['first']);
        $queryPrevious->setMaxResults(1);
        $previous = $queryPrevious->getResult();
        $navigation['previous'] = isset($previous[0]['id'])?$previous[0]['id']:$navigation['first'];

        $sql  = 'select e.id from Entities\\' . $entityName . ' e ' . $join . ' where e.id > ?1';
        $sql .= !empty($where) ? ' and ' . $where : '';
        $sql .= ' order by e.id asc';
        $queryNext = $this->_em->createQuery($sql);
        $queryNext->setParameter(1, $id!==NULL?$id:$navigation['first']);
        $queryNext->setMaxResults(1);
        $next = $queryNext->getResult();
        $navigation['next'] = isset($next[0]['id'])?$next[0]['id']:$navigation['last'];

        // disable some buttons on end-of-navigation
        if ($id == $navigation['first']) {
            $navigation['first'] = NULL;
            $navigation['previous'] = NULL;
        }
        if ($id == $navigation['last']) {
            $navigation['last'] = NULL;
            $navigation['next'] = NULL;
        }
        if ($navigation['first'] == $navigation['previous']) {
            $navigation['first'] = NULL;
        }
        if ($navigation['last'] == $navigation['next']) {
            $navigation['last'] = NULL;
        }

        return $navigation;
    }
    */
    
    /**
     * Checks if 2 arrays are equal
     * @param array $a, array 1
     * @param array $b, array 2
     * @param bool $strict, true if you want to type check
     */
    function array_equal($a, $b, $strict = FALSE)
    {
        if (count($a) !== count($b)) {
            return FALSE;
        }   
        sort($a);
        sort($b);
        return ($strict && $a === $b) || $a == $b;
    }
    
    /**
     * Save translation
     * 
     * @param array $translation, keys group|name|value|langId
     * @param int  $tagId 
     * @return boolean TRUE on success, else NULL
     */
    protected function _saveTranslation(array $translation, $tagId = NULL)
    {       
        try {
        	$translation['langId'] = isset($translation['langId']) ? $translation['langId'] : 1; // 1 en_US
        	
            $translateTag = array();
            $translateTag['group'] = $translation['group'];
            $translateTag['tag'] = $translation['tag'];
            $translateTag['type'] = 'db';
                        
            $translateTagModel = new Application_Model_TranslateTag();
            $translateTag = $translateTagModel->save($translateTag, $tagId);

            $translateModel = new Application_Model_Translate();
            $translateModel->saveTranslation(
                $translateTag->getId(),
                $translation['langId'],
                $translation['value']
            );
            return TRUE;
    	} catch(Exception $e) {
    		return NULL;
    	}	
    }

    public function formatOrder($data)
    {
    	if (!empty($data)) {
    		$data = str_pad($data, 9, "0", STR_PAD_LEFT);
    		sscanf($data, "%2s%2s%4s%1s", $or1, $or2, $or3, $or4);
    		$data =$or1. '-' . $or2 . '-' . $or3 . '-' . $or4;
 		return $data;
    	}
    	else {
    		return "";
    	}
    }

    public function translateDate($day) {
          $en = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");
          $nl = array("(ma)", "(di)", "(wo)", "(do)", "(vr)", "(za)", "(zo)");
          $day = str_replace($en, $nl, $day);
          return $day;
     }

}
