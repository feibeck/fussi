<?php

namespace Application\Form;

use \Zend\Form\Form as ZendForm;
use \Zend\Form\Element;
use \Zend\Form\Element\Text as TextElement;

class Player extends ZendForm
{

    public function __construct()
    {
	parent::__construct('Player');

	$name = new TextElement('name');
	$name->setLabel('Name');
	$this->add($name);

	$submit = new Element('submit');
	$submit->setValue('Speichern');
	$submit->setAttributes(array(
	    'type'  => 'submit'
	));
	$this->add($submit);
    }

}
