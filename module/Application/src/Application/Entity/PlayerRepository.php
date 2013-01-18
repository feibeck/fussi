<?php

namespace Application\Entity;

use Doctrine\ORM\EntityRepository;

class PlayerRepository extends EntityRepository
{

    public function isUniqueName($name)
    {
        $query = $this->_em->createQuery(
            'SELECT COUNT(p.id) FROM Application\Entity\Player p WHERE p.name = :name'
        );
        $query->setParameter('name', $name);
        $count = $query->getSingleScalarResult();

        return $count == 0;
    }

    public function getPlayersNotInTournament()
    {
	return $this->findAll();
    }

}
