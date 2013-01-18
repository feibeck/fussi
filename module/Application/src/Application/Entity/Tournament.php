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
    protected $teamType = self::TYPE_SINGLE;

    /**
     * @ORM\ManyToMany(targetEntity="Application\Entity\Player")
     * @ORM\JoinTable(name="tournament_players",
     *      joinColumns={@ORM\JoinColumn(name="tournament_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="player_id", referencedColumnName="id")}
     *      )
     */
    protected $players;

    public function __construct()
    {
        $this->players = new ArrayCollection();
    }

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

    /**
     * @return Player[]
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @param $data
     */
    public function exchangeArray($data)
    {
        $this->id       = (isset($data['id'])) ? $data['id'] : null;
        $this->name     = (isset($data['name'])) ? $data['name'] : null;
        $this->teamType = (isset($data['teamType'])) ? $data['teamType'] : self::TYPE_SINGLE;
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return array(
            'id'       => $this->id,
            'name'     => $this->name,
            'teamType' => $this->teamType
        );
    }

}
