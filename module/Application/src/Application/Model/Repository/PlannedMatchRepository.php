<?php
/**
 * Definition of Application\Model\Entity\PlannedMatchRepository
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
use Application\Model\Entity\League;
use Application\Model\Entity\DoubleMatch;
use Application\Model\Entity\Game;
use Application\Model\Entity\Match;
use Application\Model\Entity\SingleMatch;
use Application\Model\LeaguePeriod;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Repository for planned matches
 */
class PlannedMatchRepository extends EntityRepository
{

    /**
     * @param Match $match
     */
    public function persist(Match $match)
    {
        $this->_em->persist($match);
        $this->_em->flush();
    }

}