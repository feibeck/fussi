<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element\Select;
use Zend\Form\Element;

use Application\Entity\Player;

class PlayerToTournament extends Form
{

    /**
     * @param Player[] $players
     */
    public function __construct($players)
    {
	parent::__construct('PlayerToTournament');

	$select = new Select('player');

	$options = array();
	foreach ($players as $player) {
	    $options[$player->getId()] = $player->getName();
	}

	$select->setValueOptions($options);

	$this->add($select);

	$submit = new Element('submit');
	$submit->setValue('Hinzufügen');
	$submit->setAttributes(array(
	    'type'  => 'submit'
	));
	$this->add($submit);

    }

}
