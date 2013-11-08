<?php
/**
 * Definition of Application\Model\TournamentTournament
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

use \Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class TournamentTournament extends AbstractTournament
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
     * @param Team[]  $teams
     * @param Round[] $rounds
     */
    public function init($teams, $rounds)
    {
        $this->teams = $teams;
        $this->rounds = $rounds;
    }

    /**
     * @param PlannedMatch $plannedMatch
     * @param DoubleMatch  $match
     */
    public function matchPlayed(PlannedMatch $plannedMatch, DoubleMatch $match)
    {
        $plannedMatch->matchPlayed($match);
        $plannedMatch->getMatchForWinner()->setTeam(
            $match->getWinningTeam(),
            $plannedMatch->getMatchIndexForWinner()
        );
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

}