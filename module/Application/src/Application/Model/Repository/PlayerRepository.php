<?php
/**
 * Definition of Application\Model\Entity\PlayerRepository
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

use Application\Model\Entity\Tournament;
use Application\Model\Repository\UniqueNameInterface;
use Application\Model\Entity\Player;
use Doctrine\ORM\EntityRepository;

/**
 * Repository class for players
 */
class PlayerRepository extends EntityRepository implements \Application\Model\Repository\UniqueNameInterface
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
            'SELECT COUNT(p.id) FROM Application\Model\Entity\Player p WHERE p.name = :name'
        );
        $query->setParameter('name', $name);
        $count = $query->getSingleScalarResult();

        return $count == 0;
    }

    /**
     * Returns all players that are currently not playing in the given
     * tournament.
     *
     * @param Tournament $tournament
     *
     * @return Player[]
     */
    public function getPlayersNotInTournament(Tournament $tournament)
    {
        // TODO: Create a query (See issue #29)
        return $this->findAll();
    }

}