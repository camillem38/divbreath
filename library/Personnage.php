<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Personnage
 *
 * @author meunier.c
 */
class Personnage {

    private $_id;
    private $_nom;
    private $_life;
    private $_str;
    private $_vit;
    private $_dex;
    private $_int;
    private $_exp;
    private $_classe;
    private $_lvl;
    private $_degat;
    private $_locate;
    private $_degat_magique;
    private $_inventory;
    private $_gold;

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
    ////juste pour simplifier l'affichage des stats
   public function tableGet(array $table){
       $table_result = array();
       foreach ($table as $key){
           $method = strtolower($key);
           if(method_exists($this, $method)) {
                $table_result[]=$key ."=". $this->$method($key);
                
            }
       }
       return $table_result;
   }

    public function id() {
        return $this->_id;
    }

    public function nom() {
        return $this->_nom;
    }

    public function life() {
        return $this->_life;
    }

    public function str() {
        return $this->_str;
    }

    public function vit() {
        return $this->_vit;
    }

    public function dex() {
        return $this->_dex;
    }
    
    public function exp(){
        return $this->_exp;
    }
    public function degat_magique(){
        return $this->_degat_magique;
    }

    public function int() {
        return $this->_int;
    }

    public function classe() {
        return $this->_classe;
    }

    public function lvl() {
        return $this->_lvl;
    }
    
    public function degat() {
        return $this->_degat;
    }
    
    public function locate() {
        return $this->_locate;
    }
    public function inventory(){
        return $this->_inventory;
    }

    public function gold(){
        return $this->_gold;
    }
    public function setId($id) {
        $id = (int) $id;

        if ($id > 0) {
            $this->_id = $id;
        }
    }

    public function setNom($nom) {
        if (is_string($nom)) {
            $this->_nom = $nom;
        }
    }

    public function setExp($exp){
        $exp = (int)$exp;
        $this->_exp = $exp;
    }
    public function setLife($life) {
        $life = (int) $life;
        if ($life > 0) {
            $this->_life = $life;
        }
    }

    public function setStr($str) {
        $str = (int) $str;
        if ($str > 0) {
            $this->_str = $str;
        }
    }

    public function setVit($vit) {
        $vit = (int) $vit;
        if ($vit > 0) {
            $this->_vit = $vit;
        }
    }
     public function setDegat_magique($degat_magique) {
        $degat_magique = (int) $degat_magique;
        if ($degat_magique > 0) {
            $this->_degat_magique = $degat_magique;
        }
    }

    public function setInt($int) {
        $int = (int) $int;
        if ($int > 0) {
            $this->_int = $int;
        }
    }

    public function setDex($dex) {
        $dex = (int) $dex;
        if ($dex > 0) {
            $this->_dex = $dex;
        }
    }

    public function setClasse($classe) {
        if (is_string($classe)) {
            $this->_classe = $classe;
        }
    }

    public function setLvl($lvl) {
        $lvl = (int) $lvl;
        if ($lvl > 0) {
            $this->_lvl = $lvl;
        }
    }
    
    public function setDegat($degat){
        $degat = (int) $degat;
        if ($degat > 0) {
            $this->_degat = $degat;
        }
    }
    public function setLocate($locate){
        $this->_locate = $locate;
    }
    
    public function setInventory($inventory){
        $this->_inventory = $inventory;
    }
    
    public function setGold($gold){
        $this->_gold = $gold;
    }
    
    

    public function nomValide(){
        $nom = $this->_nom;
        $invalide = 0;
        if(!is_string($nom)){
           $invalide++;
        }
        if(preg_match('`^([a-zA-Z0-9-_]{2,36})$`', $nom)==0){
            $invalide++;
        }
        if($invalide>0){
            return false;
        }else{
            return true;
        }
    }
    
    public function frapper(Personnage $ennemy){
        $Mesdegats = $this->_degat;
        $vieennemy = $ennemy->life();
        $vieapredegat = $vieennemy - $Mesdegats;
        if($vieapredegat<0){
            $vieapredegat = 0;
        }
        $ennemy->setLife($vieapredegat);
        return $vieapredegat;
    }
}

?>
