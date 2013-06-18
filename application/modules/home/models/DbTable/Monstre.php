<?php

class Home_Model_DbTable_Monstre extends Zend_Db_Table_Abstract {

    protected $_name = 'mob_proto';
    protected $_primary = 'id_monstre';

    public function init() {
        require_once 'Monstre.php';
    }

    public function countMonster() {
        $select = $this->fetchRow($this->select()->from("mob_proto", array("count" => "COUNT(*)")));
        return $select["count"];
    }

    public function getMonsterByLvl($lvl) {
        return $this->fetchAll($this->select()
                                ->where('lvl = ?', $lvl));
    }

    public function getMonsterById($id) {
        return $this->fetchRow($this->select()
                                ->where('id_monstre = ?', $id));
    }

    public function getMonster($id) {
        if (is_int($id)) {
            $array = $this->fetchRow($this->select()->where('id_monstre = ?', $id))->toArray();

            return new Monstre($array);
        } else {
            $array = $this->fetchRow($this->select()->where('name = ?', $id));

            return new Monstre($array);
        }
    }

    public function getList() {
        $monstre = array();
        $arrayMonsters = $this->fetchAll($this->select()->order(array('name asc')))->toArray();
        for ($i = 0; $i < count($arrayMonsters); $i++) {
            $monstre[] = new Monstre($arrayMonsters[$i]);
        }

        return $monstre;
    }

    public function getDrop(Monstre $monstre) {
        $DropMonstre = new Home_Model_DbTable_MonstreDrop();
        $ItemProto = new Home_Model_DbTable_ItemProto();
        $drops = $DropMonstre->getDropByMonstreId($monstre->id());
        $tab = array();
        foreach ($drops as $drop) {
            $item_proto = $ItemProto->getItemProto($drop->item_proto_id);
            $taux = ($drop->taux) / 100;
            $rate = (double) $taux;
            $max = 1 / $rate; // 100
            if (mt_rand(0, $max) === 0) {
                $tab[] = $item_proto;
            }
        }

        return $tab;
    }

}