<?php

class Home_Model_DbTable_MonstreDrop extends Zend_Db_Table_Abstract {

    protected $_name = 'mob_drop';
    protected $_primary = 'mob_drop_id';

    public function init(){
        
    }
    
    public function getDropByMonstreId($id){
        
        $select = $this->fetchAll($this->select()->where('mob_id = ?', $id));
        return $select;
    }
    
  
}