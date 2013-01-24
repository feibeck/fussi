<?php

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

    public function getName()
    {
        return sprintf(
            "%s / %s",
            $this->getAttackingPlayer()->getName(),
            $this->getDefendingPlayer()->getName()
        );
    }

}
