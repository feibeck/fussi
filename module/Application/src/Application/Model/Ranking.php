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
use \Application\Model\Entity\Match;
use \Application\Model\Entity\Game;

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

                foreach ($match->getGames() as $game) {

                    $this->setRankingForTeam(
                        $team1Player1,
                        $team1Player2,
                        Game::TEAM_ONE,
                        $game
                    );

                    $this->setRankingForTeam(
                        $team2Player1,
                        $team2Player2,
                        Game::TEAM_TWO,
                        $game
                    );

                }

            } else {

                $player1 = $this->getPlayerRanking($match->getPlayer1());
                $player2 = $this->getPlayerRanking($match->getPlayer2());

                foreach ($match->getGames() as $game) {

                    $this->setRankingForPlayer(
                        $player1,
                        Game::TEAM_ONE,
                        Game::TEAM_TWO,
                        $game
                    );

                    $this->setRankingForPlayer(
                        $player2,
                        Game::TEAM_TWO,
                        Game::TEAM_ONE,
                        $game
                    );

                }

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
            if (isset($this->playerRankings[$playerid])) {
                $this->playerRankings[$playerid]->potential = $playerPotential;
            }
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
     * @param Game $game
     * @param int  $teamIndex
     *
     * @return int
     */
    protected function getPointsForPlayer(Game $game, $teamIndex)
    {
        $goalsPlayer = $game->getGoalsForTeam($teamIndex);
        $goalsOpponent = $game->getGoalsForTeam($this->getOpponentIndex($teamIndex));

        return $goalsPlayer > $goalsOpponent ? 1 : 0;
    }

    /**
     * @param \Application\Model\PlayerRanking $player1
     * @param \Application\Model\PlayerRanking $player2
     * @param int                              $teamIndex
     * @param \Application\Model\Entity\Game   $game
     */
    protected function setRankingForTeam(
        $player1,
        $player2,
        $teamIndex,
        $game
    ) {
        $opponentIndex = $this->getOpponentIndex($teamIndex);

        $this->setRankingForPlayer(
            $player1,
            $teamIndex,
            $opponentIndex,
            $game
        );

        $this->setRankingForPlayer(
            $player2,
            $teamIndex,
            $opponentIndex,
            $game
        );
    }

    /**
     * @param \Application\Model\PlayerRanking $player
     * @param int                              $teamIndex
     * @param int                              $opponentIndex
     * @param \Application\Model\Entity\Game   $game
     */
    protected function setRankingForPlayer(
        $player,
        $teamIndex,
        $opponentIndex,
        $game
    ) {
        $player->addGoals($game->getGoalsForTeam($teamIndex));
        $player->addGoalsAgainst($game->getGoalsForTeam($opponentIndex));

        $player->addPoints($this->getPointsForPlayer($game, $teamIndex));
    }

    /**
     * @param int $index
     *
     * @return int
     */
    protected function getOpponentIndex($index)
    {
        return ($index % 2) + 1;
    }

}
