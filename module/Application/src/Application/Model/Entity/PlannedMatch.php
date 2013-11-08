<?php
/**
 * Definition of Application\Model\Entity\PlannedMatch
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
 * @ORM\Entity
 * @ORM\Table(name="plannedmatch")
 */
class PlannedMatch
{

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    /**
     * @var League
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\League")
     * @ORM\JoinColumn(name="tournament_id", referencedColumnName="id")
     */
    protected $tournament;

    /**
     * @var Team
     */
    protected $team1;

    /**
     * @var Team
     */
    protected $team2;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\Player")
     * @ORM\JoinColumn(name="team1_player1_id", referencedColumnName="id")
     */
    protected $team1Player1;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\Player")
     * @ORM\JoinColumn(name="team1_player2_id", referencedColumnName="id")
     */
    protected $team1Player2;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\Player")
     * @ORM\JoinColumn(name="team2_player1_id", referencedColumnName="id")
     */
    protected $team2Player1;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\Player")
     * @ORM\JoinColumn(name="team2_player2_id", referencedColumnName="id")
     */
    protected $team2Player2;

    /**
     * @var DoubleMatch
     *
     * @ORM\ManyToOne(targetEntity="Application\Model\Entity\Match")
     * @ORM\JoinColumn(name="played_match_id", referencedColumnName="id")
     */
    protected $match;

    /**
     * @var PlannedMatch
     *
     * @ORM\ManyToOne(targetEntity="Application\Model\Entity\PlannedMatch")
     * @ORM\JoinColumn(name="team1_winner_from_planned_match_id", referencedColumnName="id")
     */
    protected $team1WinnerFromMatch = null;

    /**
     * @var PlannedMatch
     *
     * @ORM\ManyToOne(targetEntity="Application\Model\Entity\PlannedMatch")
     * @ORM\JoinColumn(name="team2_winner_from_planned_match_id", referencedColumnName="id")
     */
    protected $team2WinnerFromMatch = null;

    /**
     * @var PlannedMatch
     *
     * @ORM\ManyToOne(targetEntity="Application\Model\Entity\PlannedMatch")
     * @ORM\JoinColumn(name="winner_plays_in_planned_match_id", referencedColumnName="id")
     */
    protected $winnerPlaysInMatch = null;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $winnerPlaysInMatchAt = null;

    /**
     * @param Team $team1
     * @param Team $team2
     */
    public function __construct(Team $team1 = null, Team $team2 = null)
    {
        if ($team1 != null) {
            $this->setTeam1($team1);
        }
        if ($team2 != null) {
            $this->setTeam2($team2);
        }
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
     * @param League $tournament
     */
    public function setTournament(League $tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * @return League
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * @param Team $team
     */
    public function setTeam1(Team $team)
    {
        $this->team1 = $team;
        $this->team1Player1 = $team->getAttackingPlayer();
        $this->team1Player2 = $team->getDefendingPlayer();
    }

    /**
     * @param Team $team
     */
    public function setTeam2(Team $team)
    {
        $this->team2 = $team;
        $this->team2Player1 = $team->getAttackingPlayer();
        $this->team2Player2 = $team->getDefendingPlayer();
    }

    /**
     * @return Team
     */
    public function getTeam1()
    {
        if ($this->team1 == null && $this->team1Player1 != null) {
            $this->team1 = new Team($this->team1Player1, $this->team1Player2);
        }
        return $this->team1;
    }

    /**
     * @return Team
     */
    public function getTeam2()
    {
        if ($this->team2 == null && $this->team2Player1 != null) {
            $this->team2 = new Team($this->team2Player1, $this->team2Player2);
        }
        return $this->team2;
    }

    /**
     * @return string
     */
    public function getTeam1Name()
    {
        $team = $this->getTeam1();
        if ($team == null) {
            return "";
        }
        return $team->getName();
    }

    /**
     * @return string
     */
    public function getTeam2Name()
    {
        $team = $this->getTeam2();
        if ($team == null) {
            return "";
        }
        return $team->getName();
    }

    /**
     * @param Team $team
     * @param int  $index
     *
     * @throws \RuntimeException
     */
    public function setTeam(Team $team, $index)
    {
        if ($index == 0) {
            $this->setTeam1($team);
        } elseif ($index == 1) {
            $this->setTeam2($team);
        } else {
            throw new \RuntimeException("Inalid team index");
        }
    }

    /**
     * @param PlannedMatch $match
     */
    public function teamOneIsWinnerFrom(PlannedMatch $match)
    {
        $this->team1WinnerFromMatch = $match;
    }

    /**
     * @param PlannedMatch $match
     */
    public function teamTwoIsWinnerFrom(PlannedMatch $match)
    {
        $this->team2WinnerFromMatch = $match;
    }

    /**
     * @param PlannedMatch $match
     * @param int          $index
     */
    public function winnerPlaysInMatchAt(PlannedMatch $match, $index)
    {
        $this->winnerPlaysInMatch = $match;
        $this->winnerPlaysInMatchAt = $index;
    }

    /**
     * @param DoubleMatch $match
     */
    public function matchPlayed(DoubleMatch $match)
    {
        $this->match = $match;
    }

    /**
     * @return PlannedMatch
     */
    public function getMatchForWinner()
    {
        return $this->winnerPlaysInMatch;
    }

    /**
     * @return int
     */
    public function getMatchIndexForWinner()
    {
        return $this->winnerPlaysInMatchAt;
    }

}