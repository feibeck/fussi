<?php
/**
 * Definition of Application\Form\MatchFormDouble
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

use Application\Model\Entity\Team;
use Application\Model\Repository\PlayerRepository;
use Application\Model\Entity\Player;
use Zend\Form\Element\Select as SelectElement;

class MatchFormDouble extends MatchForm
{

    /**
     * @param int              $gameCount
     * @param Player[]         $players
     * @param int              $maxGoals
     * @param PlayerRepository $playerRepository
     */
    public function __construct($playerRepository, $gameCount, $maxGoals, $players)
    {
        parent::__construct($playerRepository, $gameCount, $maxGoals);

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

    /**
     * @param Team $team
     */
    public function setTeamOne(Team $team)
    {
        $this->setTeam(1, $team);
    }

    /**
     * @param Team $team
     */
    public function setTeamTwo(Team $team)
    {
        $this->setTeam(2, $team);
    }

    /**
     * @param int  $teamNumber
     * @param Team $team
     */
    protected  function setTeam($teamNumber, Team $team)
    {
        switch ($teamNumber) {
            case 1:
                $fieldAttack  = 'teamOneAttack';
                $fieldDefence = 'teamOneDefence';
                break;
            case 2:
                $fieldAttack  = 'teamTwoAttack';
                $fieldDefence = 'teamTwoDefence';
                break;
        }

        $options = array(
            $team->getPlayer1()->getId() => $team->getPlayer1()->getName(),
            $team->getPlayer2()->getId() => $team->getPlayer2()->getName()
        );
        $this->get($fieldAttack)->setValueOptions($options);
        $this->get($fieldAttack)->setValue($team->getPlayer1()->getId());

        $this->get($fieldDefence)->setValueOptions($options);
        $this->get($fieldDefence)->setValue($team->getPlayer2()->getId());
    }

}