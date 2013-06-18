<?php

class Home_Form_Register extends Zend_Form {

    public function init() {

        $this->setMethod('post')
                ->setName('identification')
                ->setAttrib('name', 'reg');

        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Identifiant : ')
                ->addValidators(array('alnum',
                    array('regex', false, '/^[a-z]/i')
                ))
                ->setRequired(true)
                ->addFilters(array('StringToLower'));
        $this->addElement($name);

        $motpasse = new Zend_Form_Element_Password('pw');
        $motpasse->setLabel('Mot de passe : ')
                ->setRequired(TRUE) ;
        $this->addElement($motpasse);

        $mail = new Zend_Form_Element_Text('mail');
        $mail->setLabel('Email : ')
                ->setRequired(TRUE);
        $this->addElement($mail);

        $valider = new Zend_Form_Element_Submit('valider');
        $valider->setLabel('Créer');
        $this->addElement($valider);

        $this->setDecorators(array(array('ViewScript',
                array('viewScript' => '/scripts/regscript.phtml'))));
    }

}

