<?php
/**
 * Definition of Application\Form\Player
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

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
