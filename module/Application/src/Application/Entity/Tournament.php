<?php
/**
 * Definition of Application\Entity\Tournament
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
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $gamesPerMatch = 1;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    protected $start;

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

    public function isSinglePlayer()
    {
        return $this->teamType == self::TYPE_SINGLE;
    }

    public function isTeams()
    {
        return $this->teamType == self::TYPE_TEAM;
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
        $this->id            = (isset($data['id'])) ? $data['id'] : null;
        $this->name          = (isset($data['name'])) ? $data['name'] : null;
        $this->teamType      = (isset($data['team-type'])) ? $data['team-type'] : self::TYPE_SINGLE;
        $this->start         = (isset($data['start-date'])) ? $data['start-date'] : new \DateTime();
        $this->gamesPerMatch = (isset($data['games-per-match'])) ? $data['games-per-match'] : 1;
     }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return array(
            'id'              => $this->id,
            'name'            => $this->name,
            'team-type'       => $this->teamType,
            'start-date'      => $this->start,
            'games-per-match' => $this->gamesPerMatch
        );
    }

    public function addPlayer(Player $player)
    {
        $this->players->add($player);
    }

    /**
     * @param int $gamesPerMatch
     */
    public function setGamesPerMatch($gamesPerMatch)
    {
        $this->gamesPerMatch = $gamesPerMatch;
    }

    /**
     * @return int
     */
    public function getGamesPerMatch()
    {
        return $this->gamesPerMatch;
    }

    /**
     * @param \DateTime $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

}