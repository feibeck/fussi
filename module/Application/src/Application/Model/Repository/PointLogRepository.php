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

use Application\Model\Entity\PointLog;
use Doctrine\ORM\EntityRepository;

class PointLogRepository extends EntityRepository
{

    public function reset()
    {
        $connection = $this->_em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $query = $dbPlatform->getTruncateTableSql('pointlog');
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
