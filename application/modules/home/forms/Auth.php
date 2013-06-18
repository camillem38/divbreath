<?php

class Home_Form_Auth extends Zend_Form
{

     public function init() {
         
        $this->setMethod('post')
             ->setName('identification')
             ->setAttrib('name', 'login');

        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Identifiant : ')
               ->setRequired(TRUE)
               ->addFilters(array('StringTrim', 'StripTags'))
               ->addValidators(array(array('validator' => 'StringLength',
                                           'options'   => array(0, 20))));
        $this->addElement($name);

        $motpasse   = new Zend_Form_Element_Password('pw');
        $motpasse->setLabel('Mot de passe : ')
                 ->setRequired(TRUE)
                 ->addFilters(array('StringTrim', 'StripTags'))
                 ->addValidators(array(array('validator' => 'StringLength',
                                             'options'   => array(0, 20))));
        $this->addElement($motpasse);

       
        $valider    = new Zend_Form_Element_Submit('valider');
        $valider->setLabel('S\'identifier')
        	->setIgnore(TRUE);
        $this->addElement($valider);
        
        $this->setDecorators(array(array('ViewScript',
                                  array('viewScript' => '/scripts/authscript.phtml'))));
    }


}

