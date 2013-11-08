<?php
/**
 * Definition of Application\Model\Entity\TournamentRepository
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

use Application\Model\Repository\UniqueNameInterface;
use Application\Model\Entity\League;
use Doctrine\ORM\EntityRepository;

/**
 * Repository class for tournaments
 */
class TournamentRepository extends EntityRepository implements UniqueNameInterface
{

    /**
     * Checks wether the given name is already used for a tournament
     *
     * @param string $name
     *
     * @return boolean False if the name is already in use, true otherwise
     */
    public function isUniqueName($name)
    {
        $query = $this->_em->createQuery(
            'SELECT COUNT(t.id) FROM Application\Model\Entity\Tournament t WHERE t.name = :name'
        );
        $query->setParameter('name', $name);
        $count = $query->getSingleScalarResult();

        return $count == 0;
    }

    /**
     * @param League $tournament
     */
    public function persist($tournament)
    {
        $this->_em->persist($tournament);
        $this->_em->flush();
    }

    /**
     * @return League[]
     */
    public function findAllWithoutEndDate()
    {
        $query = $this->_em->createQuery('SELECT l FROM Application\Model\Entity\League l WHERE l.end IS NULL');
        $tournaments = $query->getResult();
        return $tournaments;
    }

    /**
     * @return \Application\Model\Entity\League[]
     */
    public function findAllActive()
    {
        return $this->findAllWithoutEndDate();
    }
}
