<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Application\Entity\TournamentRepository")
 * @ORM\Table(name="tournament")
 */
class Tournament
{

    const TYPE_SINGLE = 0;
    const TYPE_TEAM = 1;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=150)
     */
    protected $name;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $teamType;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $teamType
     */
    public function setTeamType($teamType)
    {
        $this->teamType = $teamType;
    }

    /**
     * @return int
     */
    public function getTeamType()
    {
        return $this->teamType;
    }

}
