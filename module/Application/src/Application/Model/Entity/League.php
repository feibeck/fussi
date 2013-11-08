<?php
/**
 * Definition of Application\Model\Entity\League
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

use Application\Model\Entity\Player;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class League extends AbstractTournament
{

    const TYPE_SINGLE = 0;
    const TYPE_TEAM = 1;
    const MAXSCORE_DEFAULT = 10;

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
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $maxScore = self::MAXSCORE_DEFAULT;

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
     * @param $data
     */
    public function exchangeArray($data)
    {
        $this->id            = (isset($data['id'])) ? $data['id'] : null;
        $this->name          = (isset($data['name'])) ? $data['name'] : null;
        $this->teamType      = (isset($data['team-type'])) ? $data['team-type'] : self::TYPE_SINGLE;
        $this->gamesPerMatch = (isset($data['games-per-match'])) ? $data['games-per-match'] : 1;
        if (isset($data['start-date'])) {
            $this->setStart($data['start-date']);
        } else {
            $this->setStart(new \DateTime());
        }
        $this->maxScore      = (isset($data['max-score'])) ? $data['max-score'] : self::MAXSCORE_DEFAULT;
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
            'games-per-match' => $this->gamesPerMatch,
            'max-score'       => $this->maxScore
        );
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

    /*
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

}