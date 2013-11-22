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

use Application\Model\Entity\Player;

class PlayerRanking
{

    /**
     * @var \Application\Model\Entity\Player
     */
    protected $player;

    /**
     * @var int
     */
    protected $score = 0;

    /**
     * @var int
     */
    protected $goals = 0;

    /**
     * @var int
     */
    protected $goalsAgainst = 0;

    /**
     * @var int
     */
    protected $matches = 0;

    /**
     * @var int
     */
    public $potential = 0;

    /**
     * @param  \Application\Model\Entity\Player $player
     */
    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    /**
     * @param int $goals
     * 
     * @return void
     */
    public function addGoals($goals)
    {
        $this->goals += $goals;
    }

    /**
     * @param int $goalsAgainst
     *
     * @return void
     */
    public function addGoalsAgainst($goalsAgainst)
    {
        $this->goalsAgainst += $goalsAgainst;
    }

    /**
     * @param int $points
     * 
     * @return void
     */
    public function addPoints($points)
    {
        $this->matches++;
        $this->score += $points;
    }

    /**
     * @return int
     */
    public function getGoals()
    {
        return $this->goals;
    }

    /**
     * @return int
     */
    public function getGoalsAgainst()
    {
        return $this->goalsAgainst;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @return int
     */
    public function getMatchCount()
    {
        return $this->matches;
    }

}
