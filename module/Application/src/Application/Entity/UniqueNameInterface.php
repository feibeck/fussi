<?php
/**
 * Definition of \Application\Entity\UniqueNameInterface
 */

namespace Application\Entity;

/**
 * Repositories implementing the interface have a method to check wether the
 * name of an entity is already used in the database.
 *
 * @package Application\Entity
 */
interface UniqueNameInterface
{

    /**
     * Checks wether the given name is already used by an entity managed
     * by the given repository
     *
     * @param string $name
     *
     * @return boolean False if the name is already in use, true otherwise
     */
    public function isUniqueName($name);

}