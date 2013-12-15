<?php
/**
 * Definition of Application\Model\Entity\PointLogRepository
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

use Application\Model\Entity\Player;
use Application\Model\Entity\PointLog;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class PointLogRepository extends EntityRepository
{

    /**
     * @param Player $player
     *
     * @return PointLog[]
     */
    public function getForPlayer(Player $player)
    {
        $sql = "
            SELECT
                *
            FROM
                pointlog pl
            LEFT JOIN
                match m ON m.id = pl.match_id
            WHERE
                m.player1_id = :id
                OR
                m.player2_id = :id
                OR
                m.team1attack = :id
                OR
                m.team1defence = :id
                OR
                m.team2attack = :id
                OR
                m.team2defence = :id
            ORDER BY
                m.date DESC";

        $rsm = new ResultSetMappingBuilder($this->_em);
        $rsm->addRootEntityFromClassMetadata('Application\Model\Entity\PointLog', 'pl');

        $query = $this->_em->createNativeQuery($sql, $rsm);
        $query->setParameter('id', $player->getId());

        $logs = $query->getResult();

        return $logs;
    }

    public function reset()
    {
        $connection = $this->_em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $query = $dbPlatform->getTruncateTableSql('pointlog');
        $query = $dbPlatform->getTruncateTableSql('pointlogplayer');
        $connection->executeUpdate($query);
    }

    /**
     * @param PointLog $pointLog
     * @param bool     $flush
     */
    public function persist(PointLog $pointLog, $flush = true)
    {
        $this->_em->persist($pointLog);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function flush()
    {
        $this->_em->flush();
    }

}
