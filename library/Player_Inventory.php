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
class Player_Inventory extends SplObjectStorage {
    private $_size = 10;
    
    public function attach(Item $item,$data = null)
    {
        if(!$this->isFull())
	    parent::attach($item,$data);
    }
 
    public function detach(Item $item)
    {
        parent::detach($item);
    }
 
    public function hasItem(Item $search)
    {
        return $this->contains($search);
    }
 
    public function isFull()
    {
	return $this->count() >= $this->_size;
    }
}

?>
