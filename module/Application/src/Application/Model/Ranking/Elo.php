<?php
/**
 * Definition of Application\Model\Elo
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Model\Ranking;

use Application\Model\Entity\DoubleMatch;
use Application\Model\Entity\Match;
use Application\Model\Entity\SingleMatch;

abstract class Elo
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

    /**
     * @param Match $match
     */
    public function __construct(Match $match)
    {
        $this->match = $match;

        $this->currentPoints1 = $this->getPointsParticipant1($match);
        $this->currentPoints2 = $this->getPointsParticipant2($match);

        $this->expectedScore1 = $this->calculateExpectedScore($this->currentPoints1, $this->currentPoints2);
        $this->expectedScore2 = $this->calculateExpectedScore($this->currentPoints2, $this->currentPoints1);

        $this->newPoints1 = $this->calculateNewPoints(
            $this->currentPoints1,
            $this->expectedScore1,
            $this->getPointsFormMatch(1)
        );

        $this->newPoints2 = $this->calculateNewPoints(
            $this->currentPoints2,
            $this->expectedScore2,
            $this->getPointsFormMatch(2)
        );

        $this->difference1 = $this->newPoints1 - $this->currentPoints1;
        $this->difference2 = $this->newPoints2 - $this->currentPoints2;
    }

    /**
     * @return int
     */
    public function getDifference1()
    {
        return $this->difference1;
    }

    /**
     * @return int
     */
    public function getDifference2()
    {
        return $this->difference2;
    }

    /**
     * @return int
     */
    public function getChance1()
    {
        return round($this->expectedScore1 * 100);
    }

    /**
     * @return int
     */
    public function getChance2()
    {
        return round($this->expectedScore2 * 100);
    }

    /**
     * @return int
     */
    public function getNewPoints1()
    {
        return $this->newPoints1;
    }

    /**
     * @return int
     */
    public function getNewPoints2()
    {
        return $this->newPoints2;
    }

    /**
     * @return int
     */
    public function getCurrentPoints1()
    {
        return $this->currentPoints1;
    }

    /**
     * @return int
     */
    public function getCurrentPoints2()
    {
        return $this->currentPoints2;
    }

    /**
     * @param $participantIndex
     *
     * @return float
     */
    protected function getPointsFormMatch($participantIndex)
    {
        $winner = $this->match->getWinner();
        if ($winner == $participantIndex) {
            return 1;
        } else if ($this->match->getWinner() == 0) {
            return 0.5;
        }
        return 0;
    }

    /**
     * @return int
     */
    protected function getKFactor()
    {
        if ($this->currentPoints1 > 2400 && $this->currentPoints2 > 2400) {
            return 10;
        }
        if ($this->matchHasNewPlayer()) {
            return 30;
        }
        return 15;
    }

    /**
     * @param int   $elo
     * @param float $expectedValue
     * @param float $points
     *
     * @return int
     */
    protected function calculateNewPoints($elo, $expectedValue, $points)
    {
        return $elo + $this->getKFactor() * ($points - $expectedValue);
    }

    /**
     * @param int $points1
     * @param int $points2
     *
     * @return float
     */
    protected function calculateExpectedScore($points1, $points2)
    {
        $difference = $points2 - $points1;
        $difference = $difference < -400 ? -400 : $difference;
        $difference = $difference > 400 ? 400 : $difference;

        return 1 / (1 + (pow(10, $difference / 400)));
    }

    /**
     * @return bool
     */
    protected function matchHasNewPlayer()
    {
        foreach ($this->match->getPlayer() as $player) {
            if ($player->getMatchCount() < 30) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param Match $match
     *
     * @return int
     */
    abstract protected function getPointsParticipant1($match);

    /**
     * @param Match $match
     *
     * @return int
     */
    abstract protected function getPointsParticipant2($match);

    abstract public function updatePlayers();

}
