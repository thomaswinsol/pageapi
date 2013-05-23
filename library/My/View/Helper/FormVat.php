<?php
class My_View_Helper_FormVat
		extends Zend_View_Helper_FormElement{
	
	protected $html = '';	

	
	protected function getCountryCodes(){
		    $countryModel = new Share_Models_Land();
		    $options = array(
		    				'key'	=> 'LandCode',
		    				'value' => 'LandCode',		    				
		    			);
            $countries    = $countryModel->buildSelect($options);
			return $countries;		
	}
	
	
			
	public function FormVat($name, $value = null, $attribs = null)
    {
    	$countryCode = $vatNumber = '';
    	if (is_array($value)){
    	//array
    		$countryCode = isset($value['countryCode']) ? $value['countryCode'] : '';
    		$vatNumber   = isset($value['vatNumber']) ? $value['vatNumber'] : '';
    	}
    	else { 
    	//string
    		if (!empty($value)){ 
    			$data = explode(' ',$value);
    			$countryCode = isset($data[0]) ? $data[0] : '';
    			$vatNumber   = isset($data[1]) ? $data[1] : '';
    		}    		    		
    	}
    	
    	$helper = new Zend_View_Helper_FormSelect();
    	$helper->setView($this->view);
    	$this->html .= $helper->formSelect($name . '[countryCode]',$countryCode, array(), $this->getCountryCodes());    	    	
    	
    	$helper = new Zend_View_Helper_FormText();
    	$helper->setView($this->view);    	
    	$this->html .= ' '.$helper->formText($name . '[vatNumber]', $vatNumber, array());    	
    	
    	return $this->html;
    }
	
}