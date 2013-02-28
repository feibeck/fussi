<?php
/**
 * Definition of Application\Entity\Team
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Entity;

class Team
{

    /**
     * @var Player
     */
    protected $attack;

    /**
     * @var Player
     */
    protected $defence;

    /**
     * @param Player $attack  The attacking player
     * @param Player $defence The defending player
     */
    public function __construct(Player $attack, Player $defence)
    {
        $this->attack = $attack;
        $this->defence = $defence;
    }

    /**
     * @return Player
     */
    public function getAttackingPlayer()
    {
        return $this->attack;
    }

    /**
     * @return Player
     */
    public function getDefendingPlayer()
    {
        return $this->defence;
    }

    /**
     * Returns a string representation as a name of the team
     *
     * @return string
     */
    public function getName()
    {
        return sprintf(
            "%s / %s",
            $this->getAttackingPlayer()->getName(),
            $this->getDefendingPlayer()->getName()
        );
    }

}