<?php

class Home_Model_DbTable_Classe extends Zend_Db_Table_Abstract {

    protected $_name = 'classe';
    protected $_primary = 'id_classe';

    public function getClasseByName($name) {
        return $this->fetchRow($this->select()
                                ->where('nom = ?', $name));
    }

    public function listAllNameClasse() {
        $arrayClasses = $this->fetchAll($this->select()->from("classe", "nom"))->toArray();
        for ($i = 0; $i < count($arrayClasses); $i++) {
            $classes[$arrayClasses[$i]['nom']] = $arrayClasses[$i]['nom'];
        }

        return $classes;
    }

    public function setStatsByClasse(Personnage $perso) {
        $classe = $this->getClasseByName($perso->classe());
        $int = $classe['int'];
        $str = $classe['str'];
        $vit = $classe['vit'];
        $degat_magique = 3 * (int) $int;
        $life = 100 + (8 * (int) $vit);
        $degat =3 * (int) $str;
        $dex = $classe['dex'];
        $perso->setDegat($degat);
        $perso->setDex($dex);
        $perso->setInt($int);
        $perso->setLife($life);
        $perso->setStr($str);
        $perso->setVit($vit);
        $perso->setDegat_magique($degat_magique);
    }

    public function upStats(Personnage $perso) {
        $classe = $this->getClasseByName($perso->classe());
        $int = $perso->int()+$classe['int'];
        $str = $perso->str()+$classe['str'];
        $vit = $perso->vit()+$classe['vit'];
        $dex = $perso->dex()+$classe['dex'];
        $def = $perso->defense()+$classe['vit'];
        $degat_magique = $perso->degat_magique() + 3 * (int) $int;
        $life_max = 100+ (8 * (int) $vit);
        if($perso->life()+(8* (int)$classe['vit'])>=$life_max){
            $life = $life_max;
        }else{
            $life = $perso->life()+(8* (int)$classe['vit']);
        }
        
        $degat =  3 * (int) $str;
        $perso->setDegat($degat);
        $perso->setDex($dex);
        $perso->setInt($int);
        $perso->setLife($life);
        $perso->setStr($str);
        $perso->setVit($vit);
        $perso->setDefense($def);
        $perso->setDegat_magique($degat_magique);
        
    }

}