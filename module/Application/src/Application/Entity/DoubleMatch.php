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
    protected $teamOneAttack = null;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Player")
     * @ORM\JoinColumn(name="team1defence", referencedColumnName="id")
     */
    protected $teamOneDefence = null;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Player")
     * @ORM\JoinColumn(name="team2attack", referencedColumnName="id")
     */
    protected $teamTwoAttack = null;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Player")
     * @ORM\JoinColumn(name="team2defence", referencedColumnName="id")
     */
    protected $teamTwoDefence = null;

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
        if ($this->teamOneAttack == null || $this->teamOneDefence == null) {
            return null;
        }
        return new Team($this->teamOneAttack, $this->teamOneDefence);
    }

    /**
     * @return Team
     */
    public function getTeamTwo()
    {
        if ($this->teamTwoAttack == null || $this->teamTwoDefence == null) {
            return null;
        }
        return new Team($this->teamTwoAttack, $this->teamTwoDefence);
    }

}
