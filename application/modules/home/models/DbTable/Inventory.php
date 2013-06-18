<?php

class Home_Model_DbTable_Inventory extends Zend_Db_Table_Abstract {

    protected $_name = 'player_inventory';
    protected $_primary = 'inventory_id';

    public function init() {
        require_once 'Player_Inventory.php';
        require_once 'Item.php';
    }

    public function getInventory($id_player) {
        if (is_int($id_player)) {
            $arrayInventory = $this->fetchAll($this->select()->where('player_id = ?', $id_player));
            $ItemModel = new Home_Model_DbTable_Item();
           
            $storage = new Player_Inventory(); 
            foreach ($arrayInventory as $inventory) {
               
                $item = $ItemModel->getItem($inventory->item_id);
                
                $storage->attach($item);
            }
            return $storage;
        }
    }
    
    public function getInventoryRowByItem(Item $item){
        return $this->fetchRow($this->select()->where('item_id = ?', $item->item_id()));
    }
    
    public function addItemInInventory(Item $item, $id_player){
        $newRow = $this->createRow();
            $newRow->player_id = $id_player;
            $newRow->position = 1;
            $newRow->item_id = $item->item_id();
            $newRow->save();
            return $newRow->inventory_id;
    }
     public function deleteInventory(Item $item) {
        $this->fetchRow($this->select()->where('item_id = ?', $item->item_id()))->delete();
    }
    public function getInventoryById($id){
        return $this->fetchRow($this->select()->where('inventory_id = ?', $id));
    }
     public function updateInventory($inventory) {

        try {
            $newRow = $this->getInventoryById($inventory->inventory_id);
            $newRow->player_id = $inventory->player_id;
            $newRow->position = $inventory->position;
            $newRow->item_id = $inventory->item_id;
            $newRow->is_wear = $inventory->is_wear;
            
            $newRow->save();
        } catch (Exception $e) {
            echo "updateInventory($inventory)<br />";
            echo $e->getMessage();
            exit;
        }
    }

}