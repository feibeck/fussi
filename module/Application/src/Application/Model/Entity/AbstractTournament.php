<?php
/**
 * Definition of Application\Model\Entity\Game
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Base class for all match types. Matches of all types are stored in a
 * single database table (Doctrine's Single Table Inheritance).
 *
 * @see http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/inheritance-mapping.html#single-table-inheritance
 *
 * @ORM\Entity(repositoryClass="Application\Model\Repository\TournamentRepository")
 * @ORM\Table(name="tournament")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"league" = "Application\Model\Entity\League", "tournament" = "Application\Model\Entity\Tournament"})
 */
abstract class AbstractTournament
{
    const TYPE_SINGLE = 0;
    const TYPE_TEAM = 1;
    const MAXSCORE_DEFAULT = 10;

    const MODE_EXACTLY = 0;
    const MODE_BEST_OF = 1;

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=150)
     */
    protected $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Application\Model\Entity\Player")
     * @ORM\JoinTable(name="tournament_players",
     *      joinColumns={@ORM\JoinColumn(name="tournament_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="player_id", referencedColumnName="id")}
     *      )
     */
    protected $players;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $teamType = self::TYPE_TEAM;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $gamesPerMatch = 1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $matchMode = self::TYPE_TEAM;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $maxScore = self::MAXSCORE_DEFAULT;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $start;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $end;

    public function __construct()
    {
        $this->players = new ArrayCollection();
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

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Player[]
     */
    public function getPlayers()
    {
        return $this->players->toArray();
    }

    /**
     * @return string
     */
    public function getType()
    {
        if ($this instanceof Tournament) {
            return "Tournament";
        } else {
            return "League";
        }
    }

    /**
     * @param Player $player
     */
    public function addPlayer(Player $player)
    {
        // prevent from adding a player twice
        if (!$this->players->contains($player)) {
            $this->players->add($player);
        }
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
     * For best of matches you need to play at least more than half of the maximum game count.
     *
     * @return int
     */
    public function getMinimumNumberOfGames()
    {
        $gamesPerMatch = $this->getGamesPerMatch();
        if ($this->isMatchModeBestOf()) {
            $gamesPerMatch = ceil($gamesPerMatch / 2);
        }
        return (int) $gamesPerMatch;
    }

    /**
     * @param int $maxScore
     */
    public function setMaxScore($maxScore)
    {
        $this->maxScore = $maxScore;
    }

    /**
     * @return int
     */
    public function getMaxScore()
    {
        return $this->maxScore;
    }

    /**
     * @param Match        $match
     * @param PlannedMatch $plannedMatch
     */
    public function matchPlayed(Match $match, PlannedMatch $plannedMatch = null)
    {
    }

    /**
     * @param \DateTime|string $start
     */
    public function setStart($start)
    {
        if (!($start instanceof \DateTime)) {
            $start = new \DateTime($start);
        }
        $this->start = $start;
    }

    /**
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param \DateTime|null $end Casted to null if not \DateTime
     */
    public function setEnd($end)
    {
        if (!$end instanceof \DateTime) {
            $end = null;
        }

        $this->end = $end;
    }

    /**
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->end == null;
    }

    /**
     * @param int $matchMode
     */
    public function setMatchMode($matchMode)
    {
        $this->matchMode = $matchMode;
    }

    /**
     * @return int
     */
    public function getMatchMode()
    {
        return $this->matchMode;
    }

    /**
     * @return bool
     */
    public function isMatchModeBestOf()
    {
        return $this->matchMode == self::MODE_BEST_OF;
    }

    /**
     * @return bool
     */
    public function isMatchModeExactly()
    {
        return $this->matchMode == self::MODE_EXACTLY;
    }

}
