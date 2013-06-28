<?php
/**
 * Fußi
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace ApplicationTest\Model;

use Application\Model\Ranking;

class RankingTest extends \PHPUnit_Framework_TestCase
{

    protected function getPlayer($id)
    {
        $player = new \Application\Model\Entity\Player();
        $player->setId($id);
        return $player;
    }

    protected function getGame($goals1, $goals2)
    {
        $game = new \Application\Model\Entity\Game();
        $game->setGoalsTeamOne($goals1);
        $game->setGoalsTeamTwo($goals2);
        return $game;
    }

    public function testRankingPlayerEqual()
    {
        $player1 = $this->getPlayer(1);
        $player2 = $this->getPlayer(2);

        $games = array(
            array(5, 10),
            array(10, 5),
            array(5, 10),
            array(10, 5)
        );

        $match = $this->getMatch($player1, $player2, $games);

        $ranking = new Ranking(array($match));
        $playerRankings = $ranking->getRanking(2);

        $this->assertTrue($playerRankings[0]->getScore() == $playerRankings[1]->getScore());
    }

    public function testRankingPlayerOneFirst()
    {
        $player1 = $this->getPlayer(1);
        $player2 = $this->getPlayer(2);

        $games = array(
            array(10, 5),
            array(10, 5),
            array(10, 5),
            array(5, 10)
        );

        $match = $this->getMatch($player1, $player2, $games);

        $ranking = new Ranking(array($match));
        $playerRankings = $ranking->getRanking(2);

        $this->assertEquals(1, $playerRankings[0]->getPlayer()->getId());
    }

    public function testRankingPlayerTwoFirst()
    {
        $player1 = $this->getPlayer(1);
        $player2 = $this->getPlayer(2);

        $games = array(
            array(5, 10),
            array(5, 10),
            array(5, 10),
            array(10, 5)
        );

        $match = $this->getMatch($player1, $player2, $games);

        $ranking = new Ranking(array($match));
        $playerRankings = $ranking->getRanking(2);

        $this->assertEquals(2, $playerRankings[0]->getPlayer()->getId());
    }

    public function testAllGamesAreUsedForRankingCalculation()
    {
        $player1 = $this->getPlayer(1);
        $player2 = $this->getPlayer(2);

        $games = array(
            array(5, 10),
            array(10, 5),
            array(10, 5),
            array(10, 5)
        );

        $match = $this->getMatch($player1, $player2, $games);

        $ranking = new Ranking(array($match));
        $playerRankings = $ranking->getRanking(2);

        $this->assertEquals(1, $playerRankings[0]->getPlayer()->getId());
    }

    /**
     * @param \Application\Model\Entity\Player $player1
     * @param \Application\Model\Entity\Player $player2
     * @param array                            $games
     *
     * @return \Application\Model\Entity\SingleMatch
     */
    protected function getMatch($player1, $player2, $games)
    {
        $match = new \Application\Model\Entity\SingleMatch();

        $match->setPlayer1($player1);
        $match->setPlayer2($player2);

        foreach ($games as $game) {
            $match->addGame($this->getGame($game[0], $game[1]));
        }
        return $match;
    }

}

