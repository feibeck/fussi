<?php

namespace Application;

use \Application\Entity\Player;

class PlayerRanking
{

    /**
     * @var Player
     */
    protected $player;

    protected $score = 0;

    protected $goals = 0;

    protected $matches = 0;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function addGoals($goals)
    {
        $this->goals += $goals;
    }

    public function addPoints($points)
    {
        $this->matches++;
        $this->score += $points;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function getPlayer()
    {
        return $this->player;
    }

    public function getMatchCount()
    {
        return $this->matches;
    }

}
