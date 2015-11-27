<?php
/**
 * Definition of Application\Model\Entity\DoubleMatch
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Model\Entity;

use Application\Model\Team as TeamModel;
use Doctrine\ORM\Mapping as ORM;

/**
 * Represents a match between a team with two players each and an unknown
 * number of games/match.
 *
 * @ORM\Entity
 */
class DoubleMatch extends Match
{

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\Player")
     * @ORM\JoinColumn(name="team1attack", referencedColumnName="id")
     */
    protected $teamOneAttack = null;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\Player")
     * @ORM\JoinColumn(name="team1defence", referencedColumnName="id")
     */
    protected $teamOneDefence = null;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\Player")
     * @ORM\JoinColumn(name="team2attack", referencedColumnName="id")
     */
    protected $teamTwoAttack = null;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\Player")
     * @ORM\JoinColumn(name="team2defence", referencedColumnName="id")
     */
    protected $teamTwoDefence = null;

    /**
     * @param Player $attack
     * @param Player $defence
     */
    public function setTeamOne(Player $attack, Player $defence)
    {
        $this->teamOneAttack = $attack;
        $this->teamOneDefence = $defence;
    }

    /**
     * @param Player $attack
     * @param Player $defence
     */
    public function setTeamTwo(Player $attack, Player $defence)
    {
        $this->teamTwoAttack = $attack;
        $this->teamTwoDefence = $defence;
    }

    /**
     * @return TeamModel
     */
    public function getTeamOne()
    {
        if ($this->teamOneAttack == null || $this->teamOneDefence == null) {
            return null;
        }
        return new TeamModel($this->teamOneAttack, $this->teamOneDefence);
    }

    /**
     * @return TeamModel
     */
    public function getTeamTwo()
    {
        if ($this->teamTwoAttack == null || $this->teamTwoDefence == null) {
            return null;
        }
        return new TeamModel($this->teamTwoAttack, $this->teamTwoDefence);
    }

    /**
     * @return TeamModel
     */
    public function getWinningTeam()
    {
        $index = $this->getWinner();
        if ($index == 1) {
            return $this->getTeamOne();
        }
        return $this->getTeamTwo();
    }

    /**
     * Returns a list of all players involved in a match.
     *
     * @return Player[]
     */
    public function getPlayer()
    {
        return array(
            $this->getTeamOne()->getAttackingPlayer(),
            $this->getTeamOne()->getDefendingPlayer(),
            $this->getTeamTwo()->getAttackingPlayer(),
            $this->getTeamTwo()->getDefendingPlayer(),
        );
    }

    /**
     * @param Player $player
     *
     * @return int
     *
     * @throws \RuntimeException
     */
    public function getSideForPlayer(Player $player)
    {
        if ($player == $this->teamOneAttack || $player == $this->teamOneDefence) {
            return 1;
        } else if ($player == $this->teamTwoAttack || $player == $this->teamTwoDefence) {
            return 2;
        }
        throw new \RuntimeException('Player did not play in this match');
    }

}
