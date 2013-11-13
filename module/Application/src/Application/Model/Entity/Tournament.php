<?php
/**
 * Definition of Application\Model\Tournament
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

use Doctrine\Common\Collections\ArrayCollection;
use \Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Tournament extends AbstractTournament
{

    /**
     * @ORM\OneToMany(targetEntity="Application\Model\Entity\Team", mappedBy="tournament", cascade={"persist"})
     *
     * @var Team[]
     */
    protected $teams;

    /**
     * @ORM\OneToMany(targetEntity="Application\Model\Entity\Round", mappedBy="tournament", cascade={"persist"})
     *
     * @var Round[]
     */
    protected $rounds;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\Team")
     * @ORM\JoinColumn(name="winner_id", referencedColumnName="id")
     */
    protected $winner;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\Team")
     * @ORM\JoinColumn(name="second_id", referencedColumnName="id")
     */
    protected $second;

    /**
     * @param Team[]  $teams
     * @param Round[] $rounds
     */
    public function init($teams, $rounds)
    {
        $this->teams = new ArrayCollection($teams);
        foreach ($this->teams as $team) {
            $team->setTournament($this);
        }
        $this->rounds = new ArrayCollection($rounds);
        foreach ($this->rounds as $round) {
            $round->setTournament($this);
        }
        $this->start = new \DateTime();
    }

    /**
     * @param PlannedMatch $plannedMatch
     * @param Match  $match
     */
    public function matchPlayed(Match $match, PlannedMatch $plannedMatch = null)
    {
        $plannedMatch->matchPlayed($match);

        $winner = $plannedMatch->getTeam($match->getWinner() - 1);

        if ($plannedMatch->isFinal()) {

            $this->winner = $winner;

            $second = $plannedMatch->getTeam($match->getLooser() - 1);
            $this->second = $second;

            $this->end = new \DateTime();

        } else {
            $plannedMatch->getMatchForWinner()->setTeam(
                $winner,
                $plannedMatch->getMatchIndexForWinner()
            );
        }
    }

    /**
     * @return Team
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * @return Team
     */
    public function getSecond()
    {
        return $this->second;
    }

    /**
     * @return Team[]
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * @return Round[]
     */
    public function getRounds()
    {
        return $this->rounds;
    }

    /**
     * @param $data
     */
    public function exchangeArray($data)
    {
        $this->id            = (isset($data['id'])) ? $data['id'] : null;
        $this->name          = (isset($data['name'])) ? $data['name'] : null;
        $this->gamesPerMatch = (isset($data['games-per-match'])) ? $data['games-per-match'] : 1;
        $this->maxScore      = (isset($data['max-score'])) ? $data['max-score'] : self::MAXSCORE_DEFAULT;
     }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return array(
            'id'              => $this->id,
            'name'            => $this->name,
            'games-per-match' => $this->gamesPerMatch,
            'max-score'       => $this->maxScore
        );
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->start != null && $this->end == null;
    }

    /**
     * @return bool
     */
    public function isReady()
    {
        return count($this->rounds) > 0 && count($this->teams) > 0;
    }

    /**
     * @return bool
     */
    public function isFinished()
    {
        return $this->winner != null;
    }

}