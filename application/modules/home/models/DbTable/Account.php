<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Account
 *
 * @author meunier.c
 */
class Home_Model_DbTable_Account extends Zend_Db_Table_Abstract {

    protected $_name = 'account';
    protected $_primary = 'account_id';

    public function addAccount($form) {
        try {
            $newRow = $this->createRow();
            $newRow->account_name = $form->name->getValue();
            $newRow->account_pw = md5($form->pw->getValue());
            $newRow->account_mail = $form->mail->getValue();
            $newRow->save();
            return $newRow->account_id;
        } catch (Exception $e) {
            echo "addAccount($form)<br />";
            echo $e->getMessage();
            exit;
        }
    }
    
    public function getAccountById($id){
        return $this->fetchRow($this->select()
                                ->where('account_id = ?', $id));
    }
    
     public function updateAccount($session_log) {

        try {
            $newRow = $this->getAccountById($session_log->account_id);
            $newRow->account_name = $session_log->account_name;
            $newRow->account_pw = $session_log->account_pw;
            $newRow->account_mail = $session_log->account_mail;
            $newRow->account_grade = $session_log->account_grade;
            $newRow->player_id = $session_log->player_id;
            
            $newRow->save();
        } catch (Exception $e) {
            echo "updateAccount($session_log)<br />";
            echo $e->getMessage();
            exit;
        }
    }

}

?>
