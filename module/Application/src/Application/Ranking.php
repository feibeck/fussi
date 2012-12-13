<?php

namespace Application;

use \Application\PlayerRanking;
use \Application\Entity\Match;

class Ranking
{

    protected $playerRankings = array();

    /**
     * @param \Application\Entity\Match[] $matches
     */
    public function __construct($matches)
    {

        foreach ($matches as $match) {

            $player1 = $this->getPlayerRanking($match->getPlayer1());
            $player2 = $this->getPlayerRanking($match->getPlayer2());

            $player1->addGoals($match->getGoalsGame1Player1());
            $player1->addGoals($match->getGoalsGame2Player1());
            $player1->addPoints($this->getPointsPlayer1($match));

            $player2->addGoals($match->getGoalsGame1Player2());
            $player2->addGoals($match->getGoalsGame2Player2());
            $player2->addPoints($this->getPointsPlayer2($match));

        }
    }

    /**
     * @return \Application\PlayerRanking[]
     */
    public function getRanking()
    {
        uasort($this->playerRankings, function($a, $b) {
            return $b->getScore() - $a->getScore();
        });
        return array_values($this->playerRankings);
    }

    /**
     * @param $player
     * @return \Application\PlayerRanking
     */
    protected function getPlayerRanking($player)
    {
        if (!isset($this->playerRankings[$player->getId()])) {
            $this->playerRankings[$player->getId()] = new PlayerRanking($player);
        }

        return $this->playerRankings[$player->getId()];
    }

    /**
     * @param Match $match
     * 
     * @return int
     */
    protected function getPointsPlayer1(Match $match)
    {
        $won1 = $match->getGoalsGame1Player1() > $match->getGoalsGame1Player2();
        $won2 = $match->getGoalsGame2Player1() > $match->getGoalsGame2Player2();

        if ($won1 && $won2) {
            return 2;
        } else if ($won1 || $won2) {
            return 1;
        }
        return 0;
    }

    /**
     * @param Match $match
     *
     * @return int
     */
    protected function getPointsPlayer2(Match $match)
    {
        $won1 = $match->getGoalsGame1Player2() > $match->getGoalsGame1Player1();
        $won2 = $match->getGoalsGame2Player2() > $match->getGoalsGame2Player1();

        if ($won1 && $won2) {
            return 2;
        } else if ($won1 || $won2) {
            return 1;
        }
        return 0;
    }
}
