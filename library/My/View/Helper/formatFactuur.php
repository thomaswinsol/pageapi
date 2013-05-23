<?php
class My_View_Helper_formatFactuur
{
public $view;

    public function formatFactuur($data)
    {
    	if (!empty($data)) {
    		$data = str_pad($data, 7, "0", STR_PAD_LEFT);
    		sscanf($data, "%6s%1s", $or1, $or2);
    		$data =$or1. '-' . $or2 ;
 		return $this->view->escape($data);
    	}
    	else {
    		return "";
    	}
    }

    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }
}
?>
