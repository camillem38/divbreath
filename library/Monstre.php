<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Monstre
 *
 * @author meunier.c
 */
class Monstre {
    private $_id;
    private $_name;
    private $_life;
    private $_exp;
    private $_lvl;
    private $_degat;
    private $_grade;
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
      public function id() {
        return $this->_id;
    }

    public function name() {
        return $this->_name;
    }

    public function life() {
        return $this->_life;
    }
    
    public function exp(){
        return $this->_exp;
    }


    public function lvl() {
        return $this->_lvl;
    }
    
    public function degat() {
        return $this->_degat;
    }
    public function grade(){
        return $this->_grade;
    }
    
    public function gold(){
        return $this->_gold;
    }
    

    public function setId_monstre($id) {
        $id = (int) $id;

        if ($id > 0) {
            $this->_id = $id;
        }
    }

    public function setName($name) {
        if (is_string($name)) {
            $this->_name = $name;
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
    
    public function setGrade($grade){
         $grade = (int) $grade;
        if ($grade > 0) {
            $this->_grade = $grade;
        }
    }
    
    public function setGold($gold){
        $this->_gold = $gold;
    }
}

?>
