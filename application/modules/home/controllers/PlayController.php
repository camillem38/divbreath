<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PlayController
 *
 * @author meunier.c
 */
class Home_PlayController extends Zend_Controller_Action {

    public function init() {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $table_log = Zend_Auth::getInstance()->getStorage()->read();
            $this->table_log = $table_log;
            $this->perso_exist = $table_log[0]->player_id;
            require_once 'Personnage.php';
        }
    }

    public function indexAction() {
        if ($this->perso_exist != 0) {
            $Personnage = new Home_Model_DbTable_Personnage();

            $perso = $Personnage->getPlayer($this->perso_exist);
            $table = array("nom", "degat", "exp", "lvl", "locate", "life", "str", "int", "vit", "dex", "classe", "degat_magique", "gold", "defense");
            $table_stats = $perso->tableGet($table);

            $this->view->table_stats = $table_stats;
        } else {
            $this->_helper->redirector('create', 'play', 'home', array());
        }
    }

    public function createAction() {
        if ($this->perso_exist > 0) {
            $this->_helper->redirector('index', 'play', 'home', array());
        } else {
            $errorMessage = '';
            $form = new Home_Form_Playcreation();
            $Classe = new Home_Model_DbTable_Classe(); /////////A mettre en base de donnée puis en classe//////////
            $form->physique->addMultiOptions(array("Type 1", "Type 2"));
            $form->race->addMultiOptions(array("Humain"));
            $form->classe->addMultiOptions($Classe->listAllNameClasse());
            if ($this->_request->isPost()) {
                $formData = $this->_request->getPost();
                $form->populate($formData);

                if ($form->isValid($formData)) {
                    $Personnage = new Home_Model_DbTable_Personnage();
                    $Account = new Home_Model_DbTable_Account();
                    $perso = new Personnage(array("nom" => $formData["name"], "classe" => $formData["classe"]));

                    if ($perso->nomValide() != true) {
                        $errorMessage = 'Le nom choisi est invalide.';
                        unset($perso);
                    } elseif ($Personnage->playerExists($perso->nom())) {
                        $errorMessage = 'Le nom du personnage est déjà pris.';
                        unset($perso);
                    } else {
                        $Classe->setStatsByClasse($perso);
                        $perso_id = $Personnage->addPlayer($perso);
                        $session_log = $this->table_log;
                        $session_log[0]->player_id = $perso_id;
                        $authStorage = Zend_Auth::getInstance()->getStorage();
                        $authStorage->write($session_log);
                        $Account->updateAccount($session_log[0]);
                        $this->_helper->redirector('index', 'play', 'home', array());
                    }
                } else {
                    $errorMessage = "Formulaire invalide";
                }
            }
            $this->view->form = $form;
            $this->view->errorMessage = $errorMessage;
        }
    }

    public function fightAction() {

        $fight = $this->_request->getParam('id', 0);
        $Personnage = new Home_Model_DbTable_Personnage();
        $Monstre = new Home_Model_DbTable_Monstre();
        $Inventory = new Home_Model_DbTable_Inventory();
        $ItemModel = new Home_Model_DbTable_Item();
        $CoreModel = new Home_Model_DbTable_Core();
        $perso = $Personnage->getPlayer($this->perso_exist);
        $player_inventory = $Inventory->getInventory($perso->id());


        $lvl = $perso->lvl();
        $message = "";
        if (isset($fight) && $fight != "") {

            $monstre_fight = $Monstre->getMonster((int) $fight);
            if (isset($monstre_fight) && $monstre_fight != "") {
                if ($monstre_fight->lvl() == $lvl) {

                    $My_life = $perso->life();

                    $Monster_life = $monstre_fight->life();

                    while ($Monster_life > 0 && $My_life > 0) {
                        $My_degat = $CoreModel->degatVariable($perso->degat());
                        $Monster_degat = $CoreModel->degatVariable($monstre_fight->degat(), $perso->defense());
                       
                        $Monster_life-=$My_degat;
                        if ($Monster_life <= 0) {
                            $Monster_life = 0;
                            echo "<p>Vous infligez le coup fatal au " . $monstre_fight->name() . ".Vous avez tué le " . $monstre_fight->name() . "</p>";
                            echo "<p>Vous gagnez " . $monstre_fight->exp() . "points d'experience. Il vous reste " . $My_life . "points de vie.</p>";
                            $drop = $Monstre->getDrop($monstre_fight);

                            if (count($drop) > 0) {

                                foreach ($drop as $item_drop) {
                                    echo "<p>Vous recevez " . $item_drop->name . "</p>";
                                    $item_created = $ItemModel->addItem($item_drop);
                                    
                                    
                                    $Inventory->addItemInInventory($item_created, $perso->id());
                                    $inventory_row = $Inventory->getInventoryRowByItem($item_created);
                                    $item_created->setIswear($inventory_row->is_wear);
                                    $player_inventory->attach($item_created);
                                }
                            }
                            $perso->setLife($My_life);
                            $gold = $CoreModel->goldVariable($monstre_fight->gold());
                            $perso->setGold($perso->gold() + $gold);
                            echo "<p>Vous recevez " . $gold . " golds.</p>";
                            $exp = $perso->exp() + $monstre_fight->exp();
                            $Personnage->setExperience($perso, $exp);
                            $Personnage->updatePlayer($perso);
                            if ($perso->lvl() > $lvl) {
                                echo "<p>Vous gagnez " . ($perso->lvl() - $lvl) . " niveaux. Vous êtes maintenant niveau " . $perso->lvl() . "</p>";
                            }
                        } else {
                            echo "<p>Vous infligez " . $My_degat . "dégats au " . $monstre_fight->name() . ". Sa vie est abaissé à " . $Monster_life . "</p>";
                        }
                        if ($Monster_life > 0) {
                            $My_life -=$Monster_degat;
                            if ($My_life >= 0) {
                                echo "<p>Le " . $monstre_fight->name() . " vous inflige " . $Monster_degat . "dégats. Il vous reste " . $My_life . "points de vie.</p>";
                            } else {
                                $My_life = 0;
                                echo "<p>Le " . $monstre_fight->name() . " vous inflige le coup fatal, vous êtes mort.</p>";
                                $perso->setLife(1);
                                $Personnage->updatePlayer($perso);
                            }
                        }
                    }
                } else {
                    $message = "Vous ne pouvez pas combattre ce monstre";
                }
            } else {
                $message = "Ce monstre n'existe pas.";
            }
        } else {
            
        }

        $lvlupdate = $perso->lvl();
        $monstre_list = $Monstre->getMonsterByLvl($lvlupdate);
        $this->view->monstre_liste = $monstre_list;
        $this->view->message = $message;
        $this->view->items = $player_inventory;
        $this->view->player_info = $perso;
        $this->view->experience_requise = $Personnage->getPallierLvl($lvlupdate);
    }

    public function potionAction() {
        $Personnage = new Home_Model_DbTable_Personnage();
        $perso = $Personnage->getPlayer($this->perso_exist);
        $potion = 50;
        $Personnage->drinkPotion($perso, $potion);
        $this->_helper->redirector('fight', 'play', 'home', array());
    }

    public function itemuseAction() {
        $Personnage = new Home_Model_DbTable_Personnage();
        $ItemProto = new Home_Model_DbTable_ItemProto();
        $ItemModel = new Home_Model_DbTable_Item();
        $Inventory = new Home_Model_DbTable_Inventory();
        $itemId = (int) $this->_request->getParam('id', 0);

        $item = $ItemModel->getItem($itemId);

        $proto = $ItemProto->getItemProto($item->item_proto_id());

        if ($proto->type == "Consumable") {
            if ($item->stack() > 0) {
                $perso = $Personnage->getPlayer($this->perso_exist);
                $potion = $proto->value_att_1;
                $Personnage->drinkPotion($perso, $potion);
                $item->setStack($item->stack() - 1);
                $ItemModel->updateItem($item);
            }
            if ($item->stack() == 0) {
                $ItemModel->deleteItem($item);
                $Inventory->deleteInventory($item);
            }
        }
        $this->_helper->redirector('fight', 'play', 'home', array());
    }

    public function inventoryAction() {
        if ($this->perso_exist != 0) {
            $Personnage = new Home_Model_DbTable_Personnage();
            $Inventory = new Home_Model_DbTable_Inventory();
            $perso = $Personnage->getPlayer($this->perso_exist);
            $tab_inventory = $Inventory->getInventory($perso->id());

            $this->view->inventory = $tab_inventory;
        } else {
            $this->_helper->redirector('create', 'play', 'home', array());
        }
    }

    public function equipAction() {
        if ($this->perso_exist != 0) {

            $Personnage = new Home_Model_DbTable_Personnage();
            $Inventory = new Home_Model_DbTable_Inventory();
            $ItemModel = new Home_Model_DbTable_Item();
            $ItemProto = new Home_Model_DbTable_ItemProto();

            $itemId = (int) $this->_request->getParam('id', 0);

            $item = $ItemModel->getItem($itemId);
            $inventory_row = $Inventory->getInventoryRowByItem($item);

            $proto = $ItemProto->getItemProto($item->item_proto_id());
            if ($proto->is_wearable == 1 && $item->iswear() == 0) {
                $inventory_row->is_wear = 1;
                $perso = $Personnage->getPlayer($this->perso_exist);
                if ($proto->type == "Armor") {
                    $perso->setDefense($perso->defense() + $proto->value_att_1);
                } else {
                    $perso->setDegat($perso->degat() + $proto->value_att_1);
                    $Personnage->updatePlayer($perso);
                }
                $Inventory->updateInventory($inventory_row);
                $this->_helper->redirector('inventory', 'play', 'home', array());
            } else {
                $this->_helper->redirector('inventory', 'play', 'home', array());
            }
        } else {
            $this->_helper->redirector('create', 'play', 'home', array());
        }
    }

    public function unequipAction() {
        if ($this->perso_exist != 0) {
            $Personnage = new Home_Model_DbTable_Personnage();
            $Inventory = new Home_Model_DbTable_Inventory();
            $ItemModel = new Home_Model_DbTable_Item();
            $ItemProto = new Home_Model_DbTable_ItemProto();

            $itemId = (int) $this->_request->getParam('id', 0);

            $item = $ItemModel->getItem($itemId);
            $inventory_row = $Inventory->getInventoryRowByItem($item);

            $proto = $ItemProto->getItemProto($item->item_proto_id());
            if ($proto->is_wearable == 1 && $item->iswear() == 1) {
                $inventory_row->is_wear = 0;
                $perso = $Personnage->getPlayer($this->perso_exist);
                if ($proto->type == "Armor") {
                    $perso->setDefense($perso->defense() + $proto->value_att_1);
                } else {
                    $perso->setDegat($perso->degat() + $proto->value_att_1);
                    $Personnage->updatePlayer($perso);
                }
                $Inventory->updateInventory($inventory_row);
                $this->_helper->redirector('inventory', 'play', 'home', array());
            } else {
                $this->_helper->redirector('inventory', 'play', 'home', array());
            }
        } else {
            $this->_helper->redirector('create', 'play', 'home', array());
        }
    }

    public function testAction() {
        $CoreModel = new Home_Model_DbTable_Core();
        $Personnage = new Home_Model_DbTable_Personnage();
        $perso = $Personnage->getPlayer($this->perso_exist);
        $My_degat = $perso->degat();
        $test = $CoreModel->degatVariable($My_degat);
        var_dump($test);
    }

}

?>
