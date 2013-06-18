<?php

class Home_Model_DbTable_Personnage extends Zend_Db_Table_Abstract {

    protected $_name = 'player';
    protected $_primary = 'id';

    public function addPlayer(Personnage $perso) {
        try {
            $newRow = $this->createRow();
            $newRow->nom = $perso->nom();
            $newRow->locate = "cité";
            $newRow->lvl = 1;
            $newRow->exp = 0;
            $newRow->degat = $perso->degat();
            $newRow->life = $perso->life();
            $newRow->str = $perso->str();
            $newRow->int = $perso->int();
            $newRow->vit = $perso->vit();
            $newRow->dex = $perso->dex();
            $newRow->classe = $perso->classe();
            $newRow->degat_magique = $perso->degat_magique();
            $newRow->save();
            $perso->hydrate(array(
                'id' => $newRow->id
            ));
            return ($newRow->id);
        } catch (Exception $e) {
            echo "add(Personnage)<br />";
            echo $e->getMessage();
            exit;
        }
    }

    public function getPallierLvl($lvl) {
        $select = $this->fetchRow($this->select()->setIntegrityCheck(false)->from("pallier_lvl")->where("lvl = ?", $lvl));
        return $select;
    }

    public function setExperience(Personnage $perso, $exp) {
        $lvl = $perso->lvl();
        $pallier = $this->getPallierLvl($lvl);
        $experience_requise = $pallier->exp;

        $model_classe = new Home_Model_DbTable_Classe();

        if ($exp < $experience_requise) {
            $perso->setExp($exp);
        } else {
            if ($exp == $experience_requise) {
                $perso->setExp(0);
                $perso->setLvl($lvl + 1);
                $model_classe->upStats($perso);
            } else {
                $exp = $exp - $experience_requise;
                $perso->setLvl($lvl + 1);
                $model_classe->upStats($perso);
                $this->setExperience($perso, $exp);
            }
        }
    }

    public function drinkPotion(Personnage $perso, $potion) {
        $life = $perso->life();
        $life_max = 100 + 8 * $perso->vit();
        if (($life_max - $life) <= $potion) {
            $perso->setLife($life_max);
        } else {
            $perso->setLife($life + $potion);
        }
        $this->updatePlayer($perso);
    }

    public function countPlayer() {
        $select = $this->fetchRow($this->select()->from("player", array("count" => "COUNT(*)")));
        return $select["count"];
    }

    public function deletePlayer(Personnage $perso) {
        $this->fetchRow($this->select()->where('id = ?', $perso->id()))->delete();
    }

    public function playerExists($id_player) {
        if (is_int($id_player)) { // On veut voir si tel personnage ayant pour id $info existe.
            return (bool) $this->fetchRow($this->select()->where('id = ?', $id_player));
        } else {
            // Sinon, c'est qu'on veut vérifier que le nom existe ou pas.
            $select = $this->fetchRow($this->select()->from("player", array("count" => "COUNT(*)"))->where('nom = ?', $id_player));
            return (bool) $select["count"];
        }
    }

    public function getPlayer($id_player) {
        if (is_int($id_player)) {
            $arrayPlayer = $this->fetchRow($this->select()->where('id = ?', $id_player))->toArray();
        } else {
            $arrayPlayer = $this->fetchRow($this->select()->where('nom = ?', $id_player))->toArray();
        }
        $perso = new Personnage($arrayPlayer);
        $Core = new Home_Model_DbTable_Core();
        $perso->setDefense($Core->getArmorStat($perso));
        return $perso;
    }

    public function getPlayerById($id) {
        return $this->fetchRow($this->select()
                                ->where('id = ?', $id));
    }

    public function getList() {
        $persos = array();
        $arrayPlayers = $this->fetchAll($this->select()->order(array('nom asc')))->toArray();
        for ($i = 0; $i < count($arrayPlayers); $i++) {
            $persos[] = new Personnage($arrayPlayers[$i]);
        }

        return $persos;
    }

    public function updatePlayer(Personnage $perso) {

        try {
            $newRow = $this->getPlayerById($perso->id());
            $newRow->degat = $perso->degat();
            $newRow->nom = $perso->nom();
            $newRow->lvl = $perso->lvl();
            $newRow->exp = $perso->exp();
            $newRow->locate = $perso->locate();
            $newRow->life = $perso->life();
            $newRow->str = $perso->str();
            $newRow->int = $perso->int();
            $newRow->vit = $perso->vit();
            $newRow->dex = $perso->dex();
            $newRow->degat_magique = $perso->degat_magique();
            $newRow->gold = $perso->gold();
            $newRow->save();
        } catch (Exception $e) {
            echo "update(Personnage $perso)<br />";
            echo $e->getMessage();
            exit;
        }
    }

}