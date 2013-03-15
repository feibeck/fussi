<?php
/**
 * Definition of Application\Model\Ranking
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

use \Application\Model\PlayerRanking;
use Application\Model\Entity\Match;

class Ranking
{

    /**
     * @var PlayerRanking[]
     */
    protected $playerRankings = array();

    /**
     * @var Entity\Match[]
     */
    protected $matches;

    /**
     *
     * @param \Application\Model\Entity\Match[] $matches
     */
    public function __construct($matches)
    {

        $this->matches = $matches;

        foreach ($matches as $match) {

            if ($match instanceof Entity\DoubleMatch) {

                $team1 = $match->getTeamOne();
                $team2 = $match->getTeamTwo();

                $team1Player1 = $this->getPlayerRanking($team1->getAttackingPlayer());
                $team1Player2 = $this->getPlayerRanking($team1->getDefendingPlayer());
                $team2Player1 = $this->getPlayerRanking($team2->getAttackingPlayer());
                $team2Player2 = $this->getPlayerRanking($team2->getDefendingPlayer());

                $team1Player1->addGoals($match->getGoalsGame1Player1());
                $team1Player1->addGoals($match->getGoalsGame2Player1());
                $team1Player1->addPoints($this->getPointsPlayer1($match));
                $team1Player2->addGoals($match->getGoalsGame1Player1());
                $team1Player2->addGoals($match->getGoalsGame2Player1());
                $team1Player2->addPoints($this->getPointsPlayer1($match));

                $team2Player1->addGoals($match->getGoalsGame1Player2());
                $team2Player1->addGoals($match->getGoalsGame2Player2());
                $team2Player1->addPoints($this->getPointsPlayer2($match));
                $team2Player2->addGoals($match->getGoalsGame1Player2());
                $team2Player2->addGoals($match->getGoalsGame2Player2());
                $team2Player2->addPoints($this->getPointsPlayer2($match));

            } else {

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
    }

    /**
     * @param int $count Number of top scoring players to display
     *
     * @return \Application\Model\PlayerRanking[]
     */
    public function getRanking($count = 0)
    {
        uasort($this->playerRankings, function($a, $b) {
            return $b->getScore() - $a->getScore();
        });
        $ranking = array_values($this->playerRankings);
        if ($count != 0) {
            $ranking = array_slice($ranking, 0, $count);
        }

        return $ranking;
    }

    /**
     * @param int $maxMatchesPerPlayer
     *
     * @return int
     */
    public function getPotential($maxMatchesPerPlayer)
    {
        $playersRanking = $this->getRanking();
        $potential = 0;
        foreach($playersRanking as $playerid => $rank) {
            $playerPotential = $rank->getScore() + ($maxMatchesPerPlayer - $rank->getMatchCount()) * 2;
            $this->playerRankings[$playerid]->potential = $playerPotential;
            if ($playerPotential > $potential) {
                $potential = $playerPotential;
            }
        }
        if ($maxMatchesPerPlayer > count($playersRanking)+1) {
            // when not everyone has a match already
        }
        return $potential;
    }

    /**
     * @param $player
     * @return \Application\Model\PlayerRanking
     */
    protected function getPlayerRanking($player)
    {
        if (!isset($this->playerRankings[$player->getId()])) {
            $this->playerRankings[$player->getId()] = new PlayerRanking($player);
        }

        return $this->playerRankings[$player->getId()];
    }

    /**
     * @param \Application\Model\Entity\Match $match
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
     * @param \Application\Model\Entity\Match $match
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
