<?php
/**
 * Definition of \Application\Entity\TournamentRepository
 */

namespace Application\Entity;

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
	    'SELECT COUNT(t.id) FROM Application\Entity\Tournament t WHERE t.name = :name'
	);
	$query->setParameter('name', $name);
	$count = $query->getSingleScalarResult();

	return $count == 0;
    }

}
