<?php
/**
 * Definition of Application\Model\PlayerRanking
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Model;

use Application\Model\Entity\SingleMatch;

class Elo
{

    /**
     * @var int
     */
    protected $elo1;

    /**
     * @var int
     */
    protected $elo2;

    /**
     * @var float
     */
    protected $expectedValue1;

    /**
     * @var float
     */
    protected $expectedValue2;

    /**
     * @var float
     */
    protected $points1;

    /**
     * @var float
     */
    protected $points2;

    /**
     * @var SingleMatch
     */
    protected $match;

    /**
     * @param SingleMatch $match
     */
    public function __construct(SingleMatch $match)
    {
        $this->match = $match;

        $this->elo1 = $match->getPlayer1()->getPoints();
        $this->elo2 = $match->getPlayer2()->getPoints();

        $winner = $match->getWinner();
        if ($winner == 1) {
            $this->points1 = 1;
            $this->points2 = 0;
        } elseif ($winner == 2) {
            $this->points1 = 0;
            $this->points2 = 1;
        } else {
            $this->points1 = 0.5;
            $this->points2 = 0.5;
        }

        $this->expectedValue1 = $this->_calculateExpectedValue($this->elo1, $this->elo2);
        $this->expectedValue2 = $this->_calculateExpectedValue($this->elo2, $this->elo1);
    }

    public function updatePlayers()
    {
        $newElo1 = $this->newElo1();
        $newElo2 = $this->newElo2();

        $this->match->getPlayer1()->setPoints($newElo1);
        $this->match->getPlayer2()->setPoints($newElo2);
        $this->match->getPlayer1()->setMatchCount($this->match->getPlayer1()->getMatchCount() + 1);
        $this->match->getPlayer2()->setMatchCount($this->match->getPlayer2()->getMatchCount() + 1);
    }

    /**
     * @param int $points1
     * @param int $points2
     *
     * @return float
     */
    protected function _calculateExpectedValue($points1, $points2)
    {
        $difference = $points2 - $points1;
        $difference = $difference < -400 ? -400 : $difference;
        $difference = $difference > 400 ? 400 : $difference;

        return 1 / (1 + (pow(10, $difference / 400)));
    }

    /**
     * @return int
     */
    public function getChance1()
    {
        return round($this->expectedValue1 * 100);
    }

    /**
     * @return int
     */
    public function getChance2()
    {
        return round($this->expectedValue2 * 100);
    }

    /**
     * @param int   $elo
     * @param float $expectedValue
     * @param float $points
     *
     * @return int
     */
    public function _newElo($elo, $expectedValue, $points)
    {
        return $elo + $this->kFactor() * ($points - $expectedValue);
    }

    /**
     * @return int
     */
    public function newElo1()
    {
        return $this->_newElo($this->elo1, $this->expectedValue1, $this->points1);
    }

    /**
     * @return int
     */
    public function newElo2()
    {
        return $this->_newElo($this->elo2, $this->expectedValue2, $this->points2);
    }

    /**
     * @return int
     */
    protected function kFactor()
    {
        if ($this->elo1 > 2400 && $this->elo2 > 2400) {
            return 10;
        }
        if ($this->match->getPlayer1()->getMatchCount() < 30 || $this->match->getPlayer2()->getMatchCount() < 30) {
            return 30;
        }
        return 15;
    }

}