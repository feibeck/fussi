<?php
/**
 * Definition of Application\Entity\UniqueNameInterface
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