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
use Application\Model\Entity\PointLog;
use Application\Model\Entity\SingleMatch;

class Elo
{

    /**
     * @var SingleMatch|DoubleMatch
     */
    protected $match;

    /**
     * @var PointLog
     */
    protected $pointLog;

    /**
     * @param Match $match
     *
     * @return PointLog
     */
    public function calculateMatch(Match $match)
    {
        $pointLog = new PointLog($match);

        $expectedScore1 = $this->calculateExpectedScore($pointLog->getCurrentPoints1(), $pointLog->getCurrentPoints2());
        $expectedScore2 = $this->calculateExpectedScore($pointLog->getCurrentPoints2(), $pointLog->getCurrentPoints1());

        $pointLog->setChance1($this->calculateChance($expectedScore1));
        $pointLog->setChance2($this->calculateChance($expectedScore2));

        $pointLog->setNewPoints1(
            $this->calculateNewPoints(
                $match,
                $pointLog,
                $pointLog->getCurrentPoints1(),
                $expectedScore1,
                $this->getPointsFormMatch($match, 1)
            )
        );

        $pointLog->setNewPoints2(
            $this->calculateNewPoints(
                $match,
                $pointLog,
                $pointLog->getCurrentPoints2(),
                $expectedScore2,
                $this->getPointsFormMatch($match, 2)
            )
        );

        return $pointLog;
    }

    /**
     * @param Match $match
     * @param int   $participantIndex
     *
     * @return float
     */
    protected function getPointsFormMatch($match, $participantIndex)
    {
        $winner = $match->getWinner();
        if ($winner == $participantIndex) {
            return 1;
        } else if ($match->getWinner() == 0) {
            return 0.5;
        }
        return 0;
    }

    /**
     * @param Match    $match
     * @param PointLog $pointLog
     *
     * @return int
     */
    protected function getKFactor($match, $pointLog)
    {
        if ($pointLog->getCurrentPoints1() > 2400 && $pointLog->getCurrentPoints2() > 2400) {
            return 10;
        }
        if ($this->matchHasNewPlayer($match)) {
            return 30;
        }
        return 15;
    }

    /**
     * @param Match    $match
     * @param PointLog $pointLog
     * @param int      $points
     * @param float    $expectedValue
     * @param float    $matchResult
     *
     * @return int
     */
    protected function calculateNewPoints($match, $pointLog, $points, $expectedValue, $matchResult)
    {
        return $points + $this->getKFactor($match, $pointLog) * ($matchResult - $expectedValue);
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
     * @param Match $match
     *
     * @return bool
     */
    protected function matchHasNewPlayer(Match $match)
    {
        foreach ($match->getPlayer() as $player) {
            if ($player->getMatchCount() < 30) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param float $expectedScore
     *
     * @return int
     */
    protected function calculateChance($expectedScore)
    {
        return round($expectedScore * 100);
    }

}
