<?php

namespace Application;

use \Application\Entity\Player;

class PlayerRanking
{

    /**
     * @var Player
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
    protected $matches = 0;

    /**
     * @var int
     */
    public $potential = 0;

    /**
     * @param  Player $player
     * 
     * @return void
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
