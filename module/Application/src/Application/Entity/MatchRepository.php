<?php

namespace Application\Entity;

use Doctrine\ORM\EntityRepository;

class MatchRepository extends EntityRepository
{

    /**
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

    protected function getTournamentPeriod($year, $month) {
        $start =  new \DateTime();
        $start->setDate($year, $month, 1);
        $start->setTime(0, 0, 0);

        $end = clone $start;
        $end->setTime(23, 59, 59);
        $end->modify('last day of');

        return array( 0 => $start, 1 => $end);
    }

    public function getMatch($tournament, $year, $month, $player1, $player2)
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
     * Get all players who have played a match (yet) in  the tournament
     *
     * @param int $tournament Tournament Id
     * @param int $year       Year of the Tournament
     * @param int $month      Month of the Tournament
     *
     * @return array List of players that have already done a match
     */
    public function getActivePlayers($tournament, $year, $month) {
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
            $participants[$result->getPlayer1()->getId()] = true;
            $participants[$result->getPlayer2()->getId()] = true;
        }

        error_log("actives ".var_export($participants, true));
        return array_keys($participants);
    }
}