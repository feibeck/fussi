<?php
/**
 * Definition of ApplicationTest\Entity\DoubleMatchTest
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace ApplicationTest\Model\Entity;

use Application\Model\Entity\Player;
use Application\Model\Entity\Game;
use Application\Model\Entity\DoubleMatch;

/**
 * @covers Application\Model\Entity\DoubleMatch
 */
class DoubleMatchTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var DoubleMatch
     */
    protected $match;

    public function setUp()
    {
        $this->match = new DoubleMatch();
    }

    public function testEmptyTeamOne()
    {
        $this->assertEquals(null, $this->match->getTeamOne());
    }

    public function testSetTeamOne()
    {
        $player1 = new Player();
        $player2 = new Player();
        $this->match->setTeamOne($player1, $player2);
        $team = $this->match->getTeamOne();
        $this->assertSame($player1, $team->getAttackingPlayer());
        $this->assertSame($player2, $team->getDefendingPlayer());
    }

    public function testEmptyTeamTwo()
    {
        $this->assertEquals(null, $this->match->getTeamTwo());
    }

    public function testSetTeamTwo()
    {
        $player1 = new Player();
        $player2 = new Player();
        $this->match->setTeamTwo($player1, $player2);
        $team = $this->match->getTeamTwo();
        $this->assertSame($player1, $team->getAttackingPlayer());
        $this->assertSame($player2, $team->getDefendingPlayer());
    }

    public function testGetWinningTeamOne()
    {
        $game = new Game();
        $game->setGoalsTeamOne(10);
        $game->setGoalsTeamTwo(5);
        $this->match->addGame($game);

        $player1 = new Player();
        $player2 = new Player();
        $this->match->setTeamOne($player1, $player2);

        $player3 = new Player();
        $player4 = new Player();
        $this->match->setTeamTwo($player3, $player4);

        $team = $this->match->getWinningTeam();

        $this->assertSame($player1, $team->getAttackingPlayer());
        $this->assertSame($player2, $team->getDefendingPlayer());
    }

    public function testGetWinningTeamTwo()
    {
        $game = new Game();
        $game->setGoalsTeamOne(5);
        $game->setGoalsTeamTwo(10);
        $this->match->addGame($game);

        $player1 = new Player();
        $player2 = new Player();
        $this->match->setTeamOne($player1, $player2);

        $player3 = new Player();
        $player4 = new Player();
        $this->match->setTeamTwo($player3, $player4);

        $team = $this->match->getWinningTeam();

        $this->assertSame($player3, $team->getAttackingPlayer());
        $this->assertSame($player4, $team->getDefendingPlayer());
    }

    public function testGetPlayer()
    {
        $player = array(
            $this->createPlayer(1),
            $this->createPlayer(2),
            $this->createPlayer(3),
            $this->createPlayer(4),
        );
        $match = new DoubleMatch();
        $match->setTeamOne($player[0], $player[1]);
        $match->setTeamTwo($player[2], $player[3]);
        $this->assertEquals($player, $match->getPlayer());
    }

    public function testGetSideForPlayer1()
    {
        $player = array(
            $this->createPlayer(1),
            $this->createPlayer(2),
            $this->createPlayer(3),
            $this->createPlayer(4),
        );

        $this->match->setTeamOne($player[0], $player[1]);
        $this->match->setTeamTwo($player[2], $player[3]);

        $this->assertEquals(1, $this->match->getSideForPlayer($player[1]));
    }

    public function testGetSideForPlayer()
    {
        $player = array(
            $this->createPlayer(1),
            $this->createPlayer(2),
            $this->createPlayer(3),
            $this->createPlayer(4),
        );

        $this->match->setTeamOne($player[0], $player[1]);
        $this->match->setTeamTwo($player[2], $player[3]);

        $this->assertEquals(2, $this->match->getSideForPlayer($player[3]));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetSideForInvalidPlayer()
    {
        $player = array(
            $this->createPlayer(1),
            $this->createPlayer(2),
            $this->createPlayer(3),
            $this->createPlayer(4),
        );

        $this->match->setTeamOne($player[0], $player[1]);
        $this->match->setTeamTwo($player[2], $player[3]);

        $this->match->getSideForPlayer($this->createPlayer(5));
    }

    public function createPlayer($id)
    {
        $player = new Player();
        $player->setId($id);
        return $player;
    }

}
