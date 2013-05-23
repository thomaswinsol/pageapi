<?php
class My_View_Helper_formatOrder
{
public $view;

    public function formatOrder($data)
    {
    	if (!empty($data)) {
    		$data = str_pad($data, 9, "0", STR_PAD_LEFT);
    		sscanf($data, "%2s%2s%4s%1s", $or1, $or2, $or3, $or4);
    		$data =$or1. '-' . $or2 . '-' . $or3 . '-' . $or4;
 		return $this->view->escape($data);
    	}
    	else {
    		return "";
    	}
        //return 'dsqsd ' . $this->view->escape($data);
    }

    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }
}
?>
