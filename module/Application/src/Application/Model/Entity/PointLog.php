<?php
/**
 * Definition of Application\Model\Entity\Player
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

class PointLog
{

    /**
     * @var int
     */
    protected $currentPoints1;

    /**
     * @var int
     */
    protected $currentPoints2;

    /**
     * @var int
     */
    protected $newPoints1;

    /**
     * @var int
     */
    protected $newPoints2;

    /**
     * @var float
     */
    protected $expectedScore1;

    /**
     * @var float
     */
    protected $expectedScore2;

    /**
     * @var int
     */
    protected $difference1;

    /**
     * @var int
     */
    protected $difference2;

    /**
     * @var SingleMatch|DoubleMatch
     */
    protected $match;

    /**
     * @var float
     */
    protected $points1;

    /**
     * @var float
     */
    protected $points2;

    public function __construct(Match $match)
    {
        $this->match = $match;

        $this->currentPoints1 = $this->getPointsParticipant1($match);
        $this->currentPoints2 = $this->getPointsParticipant2($match);
    }

    /**
     * @param int $currentPoints1
     */
    public function setCurrentPoints1($currentPoints1)
    {
        $this->currentPoints1 = $currentPoints1;
    }

    /**
     * @return int
     */
    public function getCurrentPoints1()
    {
        return $this->currentPoints1;
    }

    /**
     * @param int $currentPoints2
     */
    public function setCurrentPoints2($currentPoints2)
    {
        $this->currentPoints2 = $currentPoints2;
    }

    /**
     * @return int
     */
    public function getCurrentPoints2()
    {
        return $this->currentPoints2;
    }

    /**
     * @return int
     */
    public function getDifference1()
    {
        return $this->getNewPoints1() - $this->getCurrentPoints1();
    }

    /**
     * @return int
     */
    public function getDifference2()
    {
        return $this->getNewPoints2() - $this->getCurrentPoints2();
    }

    /**
     * @param float $expectedScore1
     */
    public function setExpectedScore1($expectedScore1)
    {
        $this->expectedScore1 = $expectedScore1;
    }

    /**
     * @return float
     */
    public function getExpectedScore1()
    {
        return $this->expectedScore1;
    }

    /**
     * @param float $expectedScore2
     */
    public function setExpectedScore2($expectedScore2)
    {
        $this->expectedScore2 = $expectedScore2;
    }

    /**
     * @return float
     */
    public function getExpectedScore2()
    {
        return $this->expectedScore2;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DoubleMatch|SingleMatch
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * @param int $newPoints1
     */
    public function setNewPoints1($newPoints1)
    {
        $this->newPoints1 = $newPoints1;
    }

    /**
     * @return int
     */
    public function getNewPoints1()
    {
        return $this->newPoints1;
    }

    /**
     * @param int $newPoints2
     */
    public function setNewPoints2($newPoints2)
    {
        $this->newPoints2 = $newPoints2;
    }

    /**
     * @return int
     */
    public function getNewPoints2()
    {
        return $this->newPoints2;
    }

    /**
     * @param float $points1
     */
    public function setPoints1($points1)
    {
        $this->points1 = $points1;
    }

    /**
     * @return float
     */
    public function getPoints1()
    {
        return $this->points1;
    }

    /**
     * @param float $points2
     */
    public function setPoints2($points2)
    {
        $this->points2 = $points2;
    }

    /**
     * @return float
     */
    public function getPoints2()
    {
        return $this->points2;
    }

    /**
     * @return int
     */
    public function getChance1()
    {
        return round($this->getExpectedScore1() * 100);
    }

    /**
     * @return int
     */
    public function getChance2()
    {
        return round($this->getExpectedScore2() * 100);
    }

    /**
     * @return int
     */
    protected function getPointsParticipant1()
    {
        if ($this->match instanceof SingleMatch) {
            return $this->match->getPlayer1()->getPoints();
        } else if ($this->match instanceof DoubleMatch) {
            return $this->getPointsForTeam($this->match->getTeamOne());
        }
    }

    /**
     * @return int
     */
    protected function getPointsParticipant2()
    {
        if ($this->match instanceof SingleMatch) {
            return $this->match->getPlayer2()->getPoints();
        } else if ($this->match instanceof DoubleMatch) {
            return $this->getPointsForTeam($this->match->getTeamTwo());
        }
    }

    /**
     * @param Team $team
     *
     * @return float
     */
    protected function getPointsForTeam($team)
    {
        $sum = $team->getAttackingPlayer()->getPoints() + $team->getDefendingPlayer()->getPoints();
        return round($sum / 2);
    }

}
