<?php

namespace Application\Form;

use \Application\Entity\PlayerRepository;
use \Application\Entity\Player;
use Zend\Form\Element\Select as SelectElement;

class MatchFormDouble extends MatchForm
{

    /**
     * @param int              $gameCount
     * @param Player[]         $players
     * @param PlayerRepository $playerRepository
     */
    public function __construct($playerRepository, $gameCount, $players)
    {
        parent::__construct($playerRepository, $gameCount);

        $values = array(
            '' => ''
        );
        foreach ($players as $player) {
            $values[$player->getId()] = $player->getName();
        }

        $team1attack = new SelectElement('teamOneAttack');
        $team1attack->setValueOptions($values);
        $this->add($team1attack);

        $team1defence = new SelectElement('teamOneDefence');
        $team1defence->setValueOptions($values);
        $this->add($team1defence);

        $team2attack = new SelectElement('teamTwoAttack');
        $team2attack->setValueOptions($values);
        $this->add($team2attack);

        $team2defence = new SelectElement('teamTwoDefence');
        $team2defence->setValueOptions($values);
        $this->add($team2defence);

    }

}