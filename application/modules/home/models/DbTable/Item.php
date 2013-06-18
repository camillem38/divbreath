<?php

class Home_Model_DbTable_Item extends Zend_Db_Table_Abstract {

    protected $_name = 'item';
    protected $_primary = 'item_id';

    public function init(){
        require_once 'Item.php';
    }
    
    
    public function getItem($id) {
        if (is_int($id)) {
            $arrayItem = $this->fetchRow($this->select()->where('item_id = ?', $id));
            if($arrayItem!=""){
                 $ItemProtoModel = new Home_Model_DbTable_ItemProto();
                 $InventoryModel = new Home_Model_DbTable_Inventory();
                 
                $item = new Item($arrayItem->toArray());
                $inventory = $InventoryModel->getInventoryRowByItem($item);
                $itemproto = $ItemProtoModel->getItemProto($item->item_proto_id());
                $item->setNom($itemproto->name);
                $item->setType($itemproto->type);
                $item->setIswear($inventory->is_wear);
                $item->setIswearable($itemproto->is_wearable);
                return $item;
            }else{
                return false;
            }
        }
    }
    
    public function getItemById($id) {
        return $this->fetchRow($this->select()
                                ->where('item_id = ?', $id));
    }
    
    public function updateItem(Item $item) {

        try {
            $newRow = $this->getItemById($item->item_id());
            $newRow->item_proto_id = $item->item_proto_id();
            $newRow->stack = $item->stack();
            $newRow->bonus_1 = $item->bonus_1();
            $newRow->value_bonus_1 = $item->value_bonus_1();
            
            $newRow->save();
        } catch (Exception $e) {
            echo "updateItem(Item $item)<br />";
            echo $e->getMessage();
            exit;
        }
    }
    
    public function deleteItem(Item $item) {
        $this->fetchRow($this->select()->where('item_id = ?', $item->item_id()))->delete();
    }
    
    public function addItem($item_proto){
        $newRow = $this->createRow();
            $newRow->item_proto_id = $item_proto->item_proto_id;
            $newRow->stack = 1;
            $newRow->save();
            return new Item($newRow->toArray());
    }

}