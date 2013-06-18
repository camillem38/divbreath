<?php

class Home_Model_DbTable_ItemProto extends Zend_Db_Table_Abstract {

    protected $_name = 'item_proto';
    protected $_primary = 'item_proto_id';

    public function init(){
        require_once 'Item.php';
    }
    
    
    public function getItemProto($id) {
        if (is_int($id)) {
            $arrayItem = $this->fetchRow($this->select()->where('item_proto_id = ?', $id));

            return ($arrayItem);
        }
    }

}