<?php
/**
 * Definition of Application\Entity\MatchRepository
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Repository for accessing matches
 */
class MatchRepository extends EntityRepository
{

    /**
     * Returns the last 5 matches for all tournaments
     *
     * @return Match[]
     */
    public function getLastMatches()
    {
        $query = $this->_em->createQuery(
            'SELECT m FROM Application\Entity\Match m
            ORDER BY m.date DESC'
        );

        $query->setMaxResults(5);

        return $query->getResult();
    }

    /**
     * Returns all matches for tournament in a given month
     *
     * @param Tournament $tournament
     * @param int        $year
     * @param int        $month
     *
     * @return Match[]
     */
    public function findForMonth($tournament, $year, $month)
    {
        $start =  new \DateTime();
        $start->setDate($year, $month, 1);
        $start->setTime(0, 0, 0);

        $end = clone $start;
        $end->setTime(23, 59, 59);
        $end->modify('last day of');

        $query = $this->_em->createQuery(
            'SELECT m FROM Application\Entity\Match m
            WHERE m.date >= :start AND m.date <= :end
            AND m.tournament = :tournament'
        );

        $query->setParameters(
            array(
                 'start' => $start->format('Y-m-d H:i:s'),
                 'end' => $end->format('Y-m-d H:i:s'),
                 'tournament' => $tournament
            )
        );

        return $query->getResult();
    }

    /**
     * @param int $year
     * @param int $month
     *
     * @return array
     */
    protected function getTournamentPeriod($year, $month)
    {
        $start =  new \DateTime();
        $start->setDate($year, $month, 1);
        $start->setTime(0, 0, 0);

        $end = clone $start;
        $end->setTime(23, 59, 59);
        $end->modify('last day of');

        return array(0 => $start, 1 => $end);
    }

    /**
     * @param Tournament $tournament
     * @param int        $year
     * @param int        $month
     * @param Player     $player1
     * @param Player     $player2
     *
     * @return Match|null
     */
    public function getMatch(
        Tournament $tournament,
        $year,
        $month,
        Player $player1,
        Player $player2
    )
    {
        list($start, $end) = $this->getTournamentPeriod($year, $month);

        $query = $this->_em->createQuery(
            'SELECT m FROM Application\Entity\SingleMatch m
            WHERE m.date >= :start AND m.date <= :end
            AND m.player1 = :player1 AND m.player2 = :player2
            AND m.tournament = :tournament'
        );

        $query->setParameters(
            array(
                 'start' => $start->format('Y-m-d H:i:s'),
                 'end' => $end->format('Y-m-d H:i:s'),
                 'player1' => $player1,
                 'player2' => $player2,
                 'tournament' => $tournament
            )
        );

        return $query->getOneOrNullResult();
    }

    /**
     * Get all players who have played a match (yet) in the tournament
     *
     * @param int $tournament Tournament Id
     * @param int $year       Year of the Tournament
     * @param int $month      Month of the Tournament
     *
     * @return ArrayCollection List of players that have already done a match
     */
    public function getActivePlayers($tournament, $year, $month)
    {
        list($start, $end) = $this->getTournamentPeriod($year, $month);

        $query = $this->_em->createQuery(
            'SELECT m FROM Application\Entity\SingleMatch m
            WHERE m.date >= :start AND m.date <= :end
            AND m.tournament = :tournament'
            );

        $query->setParameters(
            array(
                 'start' => $start->format('Y-m-d H:i:s'),
                 'end' => $end->format('Y-m-d H:i:s'),
                 'tournament' => $tournament
            )
        );


        $participants = array();

        /** @var $results \Application\Entity\SingleMatch[] */
        $results = $query->getResult();

        foreach($results as $result) {
            $participants[$result->getPlayer1()->getId()] = $result->getPlayer1();
            $participants[$result->getPlayer2()->getId()] = $result->getPlayer2();
        }
        $participantCollection = new ArrayCollection(array_values($participants));

        return $participantCollection;
    }

    /**
     * Creates a new match
     *
     * @param Tournament $tournament
     * @param Player     $player1
     * @param Player     $player2
     *
     * @return Match
     */
    public function getNew(Tournament $tournament, $player1 = null, $player2 = null)
    {
        if ($tournament->getTeamType() == $tournament::TYPE_SINGLE) {

            $match = new SingleMatch();

            $match->setPlayer1($player1);
            $match->setPlayer2($player2);

        } else {

            $match = new DoubleMatch();

        }

        for ($i = 0; $i < $tournament->getGamesPerMatch(); $i++) {
            $match->addGame(new Game());
        }

        $match->setDate(new \DateTime());
        $match->setTournament($tournament);

        return $match;
    }

}