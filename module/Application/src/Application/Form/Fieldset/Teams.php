<?php

namespace Application\Form\Fieldset;

use Application\Entity\Game as GameEntity;
use Application\Entity\Player;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Zend\Form\Element\Select as SelectElement;

class Teams extends Fieldset implements InputFilterProviderInterface
{

    /**
     * @param Player[] $players
     */
    public function __construct()
    {
        parent::__construct('teams');

        $players = array();

        $values = array(
            '' => ''
        );
        foreach ($players as $player) {
            $values[$player->getId()] = $player->getName();
        }

        $team1attack = new SelectElement('t1a');
        $team1attack->setValueOptions($values);
        $this->add($team1attack);

        $team1defence = new SelectElement('t1d');
        $team1defence->setValueOptions($values);
        $this->add($team1defence);

        $team2attack = new SelectElement('t2a');
        $team2attack->setValueOptions($values);
        $this->add($team2attack);

        $team2defence = new SelectElement('t2d');
        $team2defence->setValueOptions($values);
        $this->add($team2defence);
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'goalsTeamOne' => array(
                'required' => true,
            ),
            'goalsTeamTwo' => array(
                'required' => true,
            )
        );
    }

}

