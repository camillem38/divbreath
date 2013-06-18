<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Play_creation
 *
 * @author meunier.c
 */
class Home_Form_Playcreation extends Zend_Form {

    public function init() {
        $this->setMethod('post')
                ->setName('identification')
                ->setAttrib('name', 'login');

        $physique = new Zend_Form_Element_Radio('physique');
       // $physique->setRequired(TRUE);
        $this->addElement($physique);

        $race = new Zend_Form_Element_Radio('race');
      //  $race->setRequired(TRUE);
        $this->addElement($race);

        $classe = new Zend_Form_Element_Radio('classe');
       // $classe->setRequired(TRUE);
        $this->addElement($classe);

        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Identifiant : ');
             /*   ->addValidators(array('alnum',
                    array('regex', false, '/^[a-z]/i')
                ))
                ->setRequired(true)
                ->addFilters(array('StringToLower'));*/
        $this->addElement($name);

        $valider = new Zend_Form_Element_Submit('valider');
        $valider->setLabel('Création du personnage');
        $this->addElement($valider);

        $this->setDecorators(array(array('ViewScript',
                array('viewScript' => '/scripts/createscript.phtml'))));
    }

}

?>
