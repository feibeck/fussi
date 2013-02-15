<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="game")
 */
class Game
{

    /**
     * @var int
     *
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Match
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Match", inversedBy="games")
     * @ORM\JoinColumn(name="match_id", referencedColumnName="id")
     */
    protected $match;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $goalsTeamOne;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $goalsTeamTwo;

    /**
     * @param int $goalsTeamOne
     */
    public function setGoalsTeamOne($goalsTeamOne)
    {
        $this->goalsTeamOne = $goalsTeamOne;
    }

    /**
     * @return int
     */
    public function getGoalsTeamOne()
    {
        return $this->goalsTeamOne;
    }

    /**
     * @param int $goalsTeamTwo
     */
    public function setGoalsTeamTwo($goalsTeamTwo)
    {
        $this->goalsTeamTwo = $goalsTeamTwo;
    }

    /**
     * @return int
     */
    public function getGoalsTeamTwo()
    {
        return $this->goalsTeamTwo;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setMatch($match)
    {
        $this->match = $match;
    }

    public function getMatch()
    {
        return $this->match;
    }

}
