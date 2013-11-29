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
    protected $elo1;

    /**
     * @var int
     */
    protected $elo2;

    /**
     * @var int
     */
    protected $newElo1;

    /**
     * @var int
     */
    protected $newElo2;

    /**
     * @var float
     */
    protected $expectedValue1;

    /**
     * @var float
     */
    protected $expectedValue2;

    /**
     * @var int
     */
    protected $diffPlayer1;

    /**
     * @var int
     */
    protected $diffPlayer2;

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

        $this->elo1 = $this->getPointsParticipant1($match);
        $this->elo2 = $this->getPointsParticipant2($match);

        $this->expectedValue1 = $this->_calculateExpectedValue($this->elo1, $this->elo2);
        $this->expectedValue2 = $this->_calculateExpectedValue($this->elo2, $this->elo1);

        $this->newElo1 = $this->_newElo(
            $this->elo1,
            $this->expectedValue1,
            $this->getPointsFormMatch(1)
        );

        $this->newElo2 = $this->_newElo(
            $this->elo2,
            $this->expectedValue2,
            $this->getPointsFormMatch(2)
        );

        $this->diffPlayer1 = $this->newElo1 - $this->elo1;
        $this->diffPlayer2 = $this->newElo2 - $this->elo2;
    }

    /**
     * @return int
     */
    public function getDiffPlayer1()
    {
        return $this->diffPlayer1;
    }

    /**
     * @return int
     */
    public function getDiffPlayer2()
    {
        return $this->diffPlayer2;
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
     * @return int
     */
    public function getNewElo1()
    {
        return $this->newElo1;
    }

    /**
     * @return int
     */
    public function getNewElo2()
    {
        return $this->newElo2;
    }

    /**
     * @return int
     */
    public function getCurrentElo1()
    {
        return $this->elo1;
    }

    /**
     * @return int
     */
    public function getCurrentElo2()
    {
        return $this->elo2;
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
    protected function kFactor()
    {
        if ($this->elo1 > 2400 && $this->elo2 > 2400) {
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
    public function _newElo($elo, $expectedValue, $points)
    {
        return $elo + $this->kFactor() * ($points - $expectedValue);
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
