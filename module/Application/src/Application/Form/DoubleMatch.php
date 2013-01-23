<?php

namespace Application\Form;

use Zend\Form\Form as ZendForm;
use Zend\Form\Element\Text as TextElement;
use Zend\Form\Element\Select as SelectElement;

use Application\Entity\Player;

class DoubleMatch extends ZendForm
{

    /**
     * @param Player[] $players
     */
    public function __construct($players)
    {
        parent::__construct('Match');

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

        $p1g1 = new TextElement('goalsGame1Team1');
        $p1g1->setAttribute('maxlength', 2);
        $p1g1->setAttribute('id', "goalsP1G1");
        $this->add($p1g1);

        $p2g1 = new TextElement('goalsGame1Team2');
        $p2g1->setAttribute('maxlength', 2);
        $p2g1->setAttribute('id', "goalsP2G1");
        $this->add($p2g1);

        $p1g2 = new TextElement('goalsGame2Team1');
        $p1g2->setAttribute('maxlength', 2);
        $p1g2->setAttribute('id', "goalsP1G2");
        $this->add($p1g2);

        $p2g2 = new TextElement('goalsGame2Team2');
        $p2g2->setAttribute('maxlength', 2);
        $p2g2->setAttribute('id', "goalsP2G2");
        $this->add($p2g2);
    }

    public function isValid()
    {
        $valid = parent::isValid();
        if (!$valid) {
            return false;
        }
        $playerIds = array(
            $this->get('t1a')->getValue(),
            $this->get('t1d')->getValue(),
            $this->get('t2a')->getValue(),
            $this->get('t2d')->getValue(),
        );
        $playerIds = array_unique($playerIds);
        return count($playerIds) == 4;
    }

}
