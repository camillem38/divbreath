<?php

class Home_IndexController extends Zend_Controller_Action {

    public function init() {
         $this->_helper->redirector('index', 'play', 'home', array());
    }

    public function indexAction() {
        
    }

}

