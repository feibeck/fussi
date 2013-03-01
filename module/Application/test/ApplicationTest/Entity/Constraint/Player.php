<?php
/**
 * Definition of ApplicationTest\Entity\Constraint\Player
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace ApplicationTest\Entity\Constraint;

class Player extends \PHPUnit_Framework_Constraint
{

    protected $id;

    protected $name;

    public function __construct($id, $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }

    public function matches($player)
    {
        return $player->getId() == $this->id && $player->getName() == $this->name;
    }

    public function toString()
    {
        return 'has correct property values';
    }

}