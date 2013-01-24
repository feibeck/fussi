<?php

namespace Application\Entity;

use Doctrine\ORM\EntityRepository;

class MatchRepository extends EntityRepository
{

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

    public function getMatch($tournament, $year, $month, $player1, $player2)
    {
        $start =  new \DateTime();
        $start->setDate($year, $month, 1);
        $start->setTime(0, 0, 0);

        $end = clone $start;
        $end->setTime(23, 59, 59);
        $end->modify('last day of');

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

}