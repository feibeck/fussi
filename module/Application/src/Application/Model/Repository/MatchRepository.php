<?php
/**
 * Definition of Application\Model\Entity\MatchRepository
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Model\Repository;

use Application\Model\Entity\AbstractTournament;
use Application\Model\Entity\Player;
use Application\Model\Entity\League;
use Application\Model\Entity\DoubleMatch;
use Application\Model\Entity\Game;
use Application\Model\Entity\Match;
use Application\Model\Entity\SingleMatch;
use Application\Model\LeaguePeriod;
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
            'SELECT m FROM Application\Model\Entity\Match m
            ORDER BY m.date DESC'
        );

        $query->setMaxResults(5);

        return $query->getResult();
    }

    /**
     * @return Match[]
     */
    public function getAllOrderedByDate()
    {
        $query = $this->_em->createQuery(
            'SELECT m FROM Application\Model\Entity\Match m
            ORDER BY m.date ASC'
        );
        return $query->getResult();
    }

    /**
     * Returns all matches for tournament in a given month
     *
     * @param \Application\Model\Entity\League $tournament
     * @param \Application\Model\LeaguePeriod
     *
     * @return Match[]
     */
    public function findForPeriod(League $tournament, LeaguePeriod $period)
    {
        $query = $this->_em->createQuery(
            'SELECT m FROM Application\Model\Entity\Match m
            WHERE m.date >= :start AND m.date <= :end
            AND m.tournament = :tournament'
        );

        $query->setParameters(
            array(
                 'start'      => $period->getStart()->format('Y-m-d H:i:s'),
                 'end'        => $period->getEnd()->format('Y-m-d H:i:s'),
                 'tournament' => $tournament
            )
        );

        return $query->getResult();
    }

    public function findForTournament(AbstractTournament $tournament)
    {
        $query = $this->_em->createQuery(
            'SELECT m FROM Application\Model\Entity\Match m
            WHERE m.tournament = :tournament'
        );

        $query->setParameters(
            array(
                 'tournament' => $tournament
            )
        );

        return $query->getResult();
    }

    /**
     * Get all players who have played a match (yet) in the tournament
     *
     * @param int          $tournament Tournament Id
     * @param LeaguePeriod $period
     *
     * @return ArrayCollection List of players that have already done a match
     */
    public function getActivePlayers($tournament, $period)
    {
        $query = $this->_em->createQuery(
            'SELECT m FROM Application\Model\Entity\SingleMatch m
            WHERE m.date >= :start AND m.date <= :end
            AND m.tournament = :tournament'
            );

        $query->setParameters(
            array(
                 'start' => $period->getStart()->format('Y-m-d H:i:s'),
                 'end' => $period->getEnd()->format('Y-m-d H:i:s'),
                 'tournament' => $tournament
            )
        );


        $participants = array();

        /** @var $results \Application\Model\Entity\SingleMatch[] */
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
     * @param AbstractTournament $tournament
     * @param Player             $player1
     * @param Player             $player2
     *
     * @return Match
     */
    public function getNew(AbstractTournament $tournament, $player1 = null, $player2 = null)
    {
        if ($tournament->getTeamType() == $tournament::TYPE_SINGLE) {

            $match = new SingleMatch();

            $match->setPlayer1($player1);
            $match->setPlayer2($player2);

        } else {

            $match = new DoubleMatch();

        }

        $gamesPerMatch = $tournament->getMinimumNumberOfGames();

        for ($i = 0; $i < $gamesPerMatch; $i++) {
            $match->addGame(new Game());
        }

        $match->setDate(new \DateTime());
        $match->setTournament($tournament);

        return $match;
    }

    /**
     * @param Match $match
     */
    public function persist(Match $match)
    {
        $this->_em->persist($match);
        $this->_em->flush();
    }

}