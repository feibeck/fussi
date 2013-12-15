<?php
/**
 * Definition of Application\Model\Entity\PointLogPlayerRepository
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

class PointLogPlayerRepository extends EntityRepository
{

    /**
     * @param Player $player
     *
     * @return PointLog[]
     */
    public function getForPlayer(Player $player)
    {
        $query = $this->_em->createQuery(
            '
                SELECT p
                FROM Application\Model\Entity\PointLogPlayer p
                WHERE p.player = :player
                ORDER BY p.id DESC
            '
        );

        $query->setParameters(array('player' => $player));
        return $query->getResult();
    }

}
