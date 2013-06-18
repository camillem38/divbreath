<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AutchController
 *
 * @author meunier.c
 */
class Home_AuthController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'index', 'home', array());
        }
        $form = new Home_Form_Auth();
        $errorMessage = '';
        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            $form->populate($formData);

            if ($form->isValid($formData)) {
                $authAdapter = $this->getAuthAdapter();
                $username = $form->getValue('name');
                $password = $form->getValue('pw');

                $authAdapter->setIdentity($username)
                        ->setCredential($password);

                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);
                if ($result->isValid()) {
                    $userInfo = $authAdapter->getResultRowObject(null, 'password');
                    $authStorage = $auth->getStorage();
                    $authStorage->write(array($userInfo));

                    $this->_helper->redirector('index', 'index', 'home', array());
                } else {
                    $errorMessage = "Nom d'utilisateur incorrect ou mot de passe incorrect.";
                }
            } else {
                $errorMessage = "Formulaire incorrect.";
            }
        }
        $this->view->form = $form;
        $this->view->errorMessage = $errorMessage;
    }

    public function registerAction() {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'index', 'home', array());
        }
        $form = new Home_Form_Register();
        $errorMessage = '';

        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            $form->populate($formData);

            if ($form->isValid($formData)) {
                $newTab = new Home_Model_DbTable_Account();
                $newTab->addAccount($form);

                $authAdapter = $this->getAuthAdapter();
                $username = $form->getValue('name');
                $password = $form->getValue('pw');

                $authAdapter->setIdentity($username)
                        ->setCredential($password);

                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);
                if ($result->isValid()) {
                    $userInfo = $authAdapter->getResultRowObject(null, 'password');
                    $authStorage = $auth->getStorage();
                    $authStorage->write(array($userInfo));

                    $this->_helper->redirector('index', 'index', 'home', array());
                } else {
                    $errorMessage = "Nom d'utilisateur incorrect ou mot de passe incorrect.";
                }
            } else {
                $errorMessage = "Formulaire incorrect.";
            }
        }


        $this->view->form = $form;
        $this->view->errorMessage = $errorMessage;
    }

    protected function getAuthAdapter() {
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('account')
                ->setIdentityColumn('account_name')
                ->setCredentialColumn('account_pw')
                ->setCredentialTreatment('MD5(?)');

        return $authAdapter;
    }

    public function logoutAction() {
        Zend_Session::destroy();
        $this->_helper->redirector('index', 'index', 'home', array());
    }

}

?>
