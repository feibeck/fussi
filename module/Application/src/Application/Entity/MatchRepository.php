<?php

namespace Application\Entity;

use Doctrine\ORM\EntityRepository;

class MatchRepository extends EntityRepository
{

    public function findForMonth($year, $month)
    {
        $start =  new \DateTime();
        $start->setDate($year, $month, 1);
        $start->setTime(0, 0, 0);

        $end = clone $start;
        $end->setTime(23, 59, 59);
        $end->modify('last day of');

        $query = $this->_em->createQuery(
            'SELECT m FROM Application\Entity\Match m
            WHERE m.date >= :start AND m.date <= :end'
        );

        $query->setParameters(
            array(
                 'start' => $start->format('Y-m-d H:i:s'),
                 'end' => $end->format('Y-m-d H:i:s'),
            )
        );

        return $query->getResult();
    }

    public function getMatch($year, $month, $player1, $player2)
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
            AND m.player1 = :player1 AND m.player2 = :player2'
        );

        $query->setParameters(
            array(
                 'start' => $start->format('Y-m-d H:i:s'),
                 'end' => $end->format('Y-m-d H:i:s'),
                 'player1' => $player1,
                 'player2' => $player2
            )
        );

        return $query->getOneOrNullResult();
    }

}