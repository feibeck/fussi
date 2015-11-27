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
use ApplicationTest\Model\Entity\Helper\PlayerHelper;

/**
 * @covers Application\Model\Entity\DoubleMatch
 */
class DoubleMatchTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var DoubleMatch
     */
    protected $match;

    /**
     * @var PlayerHelper
     */
    protected $player;

    public function setUp()
    {
        $this->match = new DoubleMatch();

        $this->player = new PlayerHelper();
        $this->player->createPlayer();
        $this->player->createPlayer();
        $this->player->createPlayer();
        $this->player->createPlayer();

        $this->match->setTeamOne($this->player[0], $this->player[1]);
        $this->match->setTeamTwo($this->player[2], $this->player[3]);
    }

    public function testEmptyTeamOne()
    {
        $match = new DoubleMatch();
        $this->assertEquals(null, $match->getTeamOne());
    }

    public function testSetTeamOne()
    {
        $team = $this->match->getTeamOne();
        $this->assertSame($this->player[0], $team->getAttackingPlayer());
        $this->assertSame($this->player[1], $team->getDefendingPlayer());
    }

    public function testEmptyTeamTwo()
    {
        $match = new DoubleMatch();
        $this->assertEquals(null, $match->getTeamTwo());
    }

    public function testSetTeamTwo()
    {
        $team = $this->match->getTeamTwo();
        $this->assertSame($this->player[2], $team->getAttackingPlayer());
        $this->assertSame($this->player[3], $team->getDefendingPlayer());
    }

    public function testGetWinningTeamOne()
    {
        $game = new Game();
        $game->setGoalsTeamOne(10);
        $game->setGoalsTeamTwo(5);
        $this->match->addGame($game);

        $team = $this->match->getWinningTeam();

        $this->assertSame($this->player[0], $team->getAttackingPlayer());
        $this->assertSame($this->player[1], $team->getDefendingPlayer());
    }

    public function testGetWinningTeamTwo()
    {
        $game = new Game();
        $game->setGoalsTeamOne(5);
        $game->setGoalsTeamTwo(10);
        $this->match->addGame($game);

        $team = $this->match->getWinningTeam();

        $this->assertSame($this->player[2], $team->getAttackingPlayer());
        $this->assertSame($this->player[3], $team->getDefendingPlayer());
    }

    public function testGetPlayer()
    {
        $this->assertEquals($this->player->players, $this->match->getPlayer());
    }

    public function testGetSideForPlayer1()
    {
        $this->assertEquals(1, $this->match->getSideForPlayer($this->player[1]));
    }

    public function testGetSideForPlayer()
    {
        $this->assertEquals(2, $this->match->getSideForPlayer($this->player[3]));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetSideForInvalidPlayer()
    {
        $this->match->getSideForPlayer($this->player->createPlayer());
    }

}
