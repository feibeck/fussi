<?php
/**
 * Definition of Application\Form\PlayerToTournament
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

use Zend\Form\Form;
use Zend\Form\Element\Select;
use Zend\Form\Element;

use Application\Model\Entity\Player;

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
        $submit->setAttributes(
            array(
                 'type'  => 'submit'
            )
        );
        $this->add($submit);

    }

}
