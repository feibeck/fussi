<?php
/**
 * Definition of \Application\Entity\PlayerRepository
 */

namespace Application\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Repository class for players
 */
class PlayerRepository extends EntityRepository implements UniqueNameInterface
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
            'SELECT COUNT(p.id) FROM Application\Entity\Player p WHERE p.name = :name'
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
	// TODO: Create a query
	return $this->findAll();
    }

}
