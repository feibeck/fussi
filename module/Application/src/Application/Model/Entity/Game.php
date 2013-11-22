<?php
/**
 * Definition of Application\Model\Entity\Game
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

use Doctrine\ORM\Mapping as ORM;

/**
 * Represents a game between two teams (or players), belonging to a match
 *
 * @ORM\Entity
 * @ORM\Table(name="game")
 */
class Game
{

    const TEAM_ONE = 1;

    const TEAM_TWO = 2;

    /**
     * @var int
     *
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Match
     *
     * @ORM\ManyToOne(targetEntity="Application\Model\Entity\Match", inversedBy="games")
     * @ORM\JoinColumn(name="match_id", referencedColumnName="id")
     */
    protected $match;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $goalsTeamOne;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $goalsTeamTwo;

    /**
     * @param int $goalsTeamOne
     */
    public function setGoalsTeamOne($goalsTeamOne)
    {
        $this->goalsTeamOne = $goalsTeamOne;
    }

    /**
     * @return int
     */
    public function getGoalsTeamOne()
    {
        return $this->goalsTeamOne;
    }

    /**
     * @param int $goalsTeamTwo
     */
    public function setGoalsTeamTwo($goalsTeamTwo)
    {
        $this->goalsTeamTwo = $goalsTeamTwo;
    }

    /**
     * @return int
     */
    public function getGoalsTeamTwo()
    {
        return $this->goalsTeamTwo;
    }

    /**
     * @param int $team Index of the team (TEAM_ONE or TEAM_TWO)
     *
     * @return int Number of goals for the given team
     *
     * @throws \InvalidArgumentException in case of an invalid team index
     */
    public function getGoalsForTeam($team)
    {
        if ($team == self::TEAM_ONE) {
            return $this->getGoalsTeamOne();
        } else if ($team == self::TEAM_TWO) {
            return $this->getGoalsTeamTwo();
        }
        throw new \InvalidArgumentException('Invalid team index');
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Match $match
     */
    public function setMatch(Match $match)
    {
        $this->match = $match;
    }

    /**
     * @return Match
     */
    public function getMatch()
    {
        return $this->match;
    }

}
