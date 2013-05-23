<?php
interface Application_Model_Interface
{
    public function getOne($id);
    public function insert($data);
    public function update($id,$data);
    public function delete($id);
    public function getAll();
    
}