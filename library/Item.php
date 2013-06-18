<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Item
 *
 * @author meunier.c
 */
class Item {

    private $_item_id;
    private $_item_proto_id;
    private $_iswearable;
    private $_stack;
    private $_bonus_1;
    private $_value_bonus_1;
    private $_nom;
    private $_type;
    private $_iswear;
    
    public function __construct(array $donnees) {
        $this->hydrate($donnees);
    }

    public function hydrate(array $donnees) {
        foreach ($donnees as $key => $value) {
            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function item_id() {
        return $this->_item_id;
    }

    public function item_proto_id() {
        return $this->_item_proto_id;
    }

    public function stack() {
        return $this->_stack;
    }

    public function bonus_1() {
        return $this->_bonus_1;
    }

    public function value_bonus_1() {
        return $this->_value_bonus_1;
    }

    public function nom(){
        return $this->_nom;
    }
    
    public function iswearable(){
        return $this->_iswearable;
    }
    
    public function type(){
        return $this->_type;
    }
    
    public function iswear(){
        return $this->_iswear;
    }
    
    public function setItem_id($id) {
        $id = (int) $id;

        if ($id > 0) {
            $this->_item_id = $id;
        }
    }

    public function setItem_proto_id($id) {
        $id = (int) $id;

        if ($id > 0) {
            $this->_item_proto_id = $id;
        }
    }

    public function setStack($exp) {
        $exp = (int) $exp;
        $this->_stack = $exp;
    }

    public function setBonus_1($life) {
        $life = (int) $life;

        $this->_bonus_1 = $life;
    }

    public function setValue_bonus_1($lvl) {
        $lvl = (int) $lvl;
        $this->_value_bonus_1 = $lvl;
    }
    
    public function setNom($nom){
        $this->_nom = $nom;
    }
    
    public function setIswearable($iswearable){
        $this->_iswearable = $iswearable;
    }
    
    public function setType($type){
        $this->_type = $type;
    }
    
    public function setIswear($iswear){
        $this->_iswear = $iswear;
    }

}

?>
