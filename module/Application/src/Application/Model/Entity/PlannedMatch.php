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
 * @ORM\Entity(repositoryClass="Application\Model\Repository\PlannedMatchRepository")
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
     * @var Tournament
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\Tournament")
     * @ORM\JoinColumn(name="tournament_id", referencedColumnName="id")
     */
    protected $tournament;

    /**
     * @var Round
     *
     * @ORM\ManyToOne(targetEntity="Application\Model\Entity\Round", inversedBy="matches")
     * @ORM\JoinColumn(name="round_id", referencedColumnName="id")
     */
    protected $round;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\Team")
     * @ORM\JoinColumn(name="team1_id", referencedColumnName="id")
     */
    protected $team1;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\Team")
     * @ORM\JoinColumn(name="team2_id", referencedColumnName="id")
     */
    protected $team2;

    /**
     * @var DoubleMatch
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\DoubleMatch")
     * @ORM\JoinColumn(name="match_id", referencedColumnName="id")
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
     * @ORM\Column(type="integer", nullable=true)
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
     * @param Tournament $tournament
     */
    public function setTournament(Tournament $tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * @return Tournament
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
    }

    /**
     * @param Team $team
     */
    public function setTeam2(Team $team)
    {
        $this->team2 = $team;
    }

    public function getTeam($index)
    {
        if ($index == 0) {
            return $this->team1;
        } else if ($index == 1) {
            return $this->team2;
        }
        throw new \RuntimeException("Invalid team index");
    }

    /**
     * @return Team
     */
    public function getTeam1()
    {
        return $this->team1;
    }

    /**
     * @return Team
     */
    public function getTeam2()
    {
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
     * @return DoubleMatch
     */
    public function getPlayedMatch()
    {
        return $this->match;
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

    /**
     * @param Round $round
     */
    public function setRound($round)
    {
        $this->round = $round;
    }

    /**
     * @return Round
     */
    public function getRound()
    {
        return $this->round;
    }

    /**
     * @return bool
     */
    public function isPlayed()
    {
        return $this->match != null;
    }

    /**
     * @return bool
     */
    public function isFinal()
    {
        return $this->winnerPlaysInMatch == null;
    }

    /**
     * @return bool
     */
    public function isReady()
    {
        return $this->team1 != null && $this->team2 != null && $this->match == null;
    }

}