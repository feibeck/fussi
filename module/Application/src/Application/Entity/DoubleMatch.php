<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class DoubleMatch extends Match
{

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Player")
     * @ORM\JoinColumn(name="team1attack", referencedColumnName="id")
     */
    protected $teamOneAttack;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Player")
     * @ORM\JoinColumn(name="team1defence", referencedColumnName="id")
     */
    protected $teamOneDefence;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Player")
     * @ORM\JoinColumn(name="team2attack", referencedColumnName="id")
     */
    protected $teamTwoAttack;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Player")
     * @ORM\JoinColumn(name="team2defence", referencedColumnName="id")
     */
    protected $teamTwoDefence;

    public function setTeamOne(Player $attack, Player $defence)
    {
        $this->teamOneAttack = $attack;
        $this->teamOneDefence = $defence;
    }

    public function setTeamTwo(Player $attack, Player $defence)
    {
        $this->teamTwoAttack = $attack;
        $this->teamTwoDefence = $defence;
    }

    /**
     * @return Team
     */
    public function getTeamOne()
    {
        return new Team($this->teamOneAttack, $this->teamOneDefence);
    }

    /**
     * @return Team
     */
    public function getTeamTwo()
    {
        return new Team($this->teamTwoAttack, $this->teamTwoDefence);
    }

}
