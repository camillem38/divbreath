<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Core
 *
 * @author meunier.c
 */
class Home_Model_DbTable_Core {
    
    function getArmorStat(Personnage $perso){
       $basic_armor = $perso->vit();
       $InventoryModel = new Home_Model_DbTable_Inventory();
       $ItemProtoModel = new Home_Model_DbTable_ItemProto();
       $inventory = $InventoryModel->getInventory($perso->id());
       if(count($inventory)>0){
         $defense = 0;
           foreach ($inventory as $row){
               if($row->type()=="Armor"){
                    $itemproto = $ItemProtoModel->getItemProto($row->item_proto_id());
                    $defense += $itemproto->value_att_1;
               }
           }
       }else{
           $defense = 0;
       }
       $armor = $basic_armor+$defense;
       return $armor;
    }
}

?>
