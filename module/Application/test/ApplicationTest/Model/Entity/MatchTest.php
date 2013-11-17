<?php
/**
 * Definition of ApplicationTest\Entity\SingleMatchTest
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

use Application\Model\Entity\Game;
use Application\Model\Entity\Player;
use Application\Model\Entity\Match;
use Application\Model\Entity\League;

/**
 * @covers Application\Model\Entity\Match
 */
class MatchTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Match
     */
    protected $match;

    public function setUp()
    {
        $this->match = $this->getMockForAbstractClass(
            'Application\Model\Entity\Match'
        );
    }

    public function testDateProperty()
    {
        $date = new \DateTime();
        $this->match->setDate($date);
        $this->assertSame($date, $this->match->getDate());
    }

    public function testIdProperty()
    {
        $this->match->setId(42);
        $this->assertSame(42, $this->match->getId());
    }

    public function testTournamentProperty()
    {
        $tournament = new League();
        $this->match->setTournament($tournament);
        $this->assertEquals($tournament, $this->match->getTournament());
    }

    public function testWinnerWithZeroGames()
    {
        $this->assertEquals(0, $this->match->getWinner());
    }

    public function testLooserWithZeroGames()
    {
        $this->assertEquals(0, $this->match->getLooser());
    }

    public function testAddingSingleGames()
    {
        $game1 = new Game();
        $game2 = new Game();
        $this->match->addGame($game1);
        $this->match->addGame($game2);
        $games = $this->match->getGames();
        $this->assertInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            $games
        );
        $this->assertSame($game1, $games[0]);
        $this->assertSame($game2, $games[1]);
    }

    public function testAddingGames()
    {
        $game1 = new Game();
        $game2 = new Game();
        $this->match->setGames(array($game1, $game2));
        $games = $this->match->getGames();
        $this->assertInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            $games
        );
        $this->assertSame($game1, $games[0]);
        $this->assertSame($game2, $games[1]);
    }

    public function testWinnerTeamOneWithOneGame()
    {
        $this->addGameToMatch(4, 2);
        $this->assertEquals(1, $this->match->getWinner());
    }

    public function testWinnerTeamOneWithTwoGame()
    {
        $this->addGameToMatch(4, 2);
        $this->addGameToMatch(8, 7);
        $this->assertTrue($this->match->isTeamOneWinner());
    }

    public function testWinnerTeamTwo()
    {
        $this->addGameToMatch(2, 5);
        $this->assertEquals(2, $this->match->getWinner());
    }

    public function testLooserTeamOne()
    {
        $this->addGameToMatch(2, 5);
        $this->assertEquals(1, $this->match->getLooser());
    }

    public function testLooserTeamTwo()
    {
        $this->addGameToMatch(5, 2);
        $this->assertEquals(2, $this->match->getLooser());
    }

    public function testWinnerTeamTwoWithTwoGames()
    {
        $this->addGameToMatch(2, 5);
        $this->addGameToMatch(2, 5);
        $this->assertTrue($this->match->isTeamTwoWinner());
    }

    public function testScore()
    {
        $this->addGameToMatch(1, 10);
        $this->addGameToMatch(10, 1);
        $this->assertEquals('1 / 1', $this->match->getScore());
    }

    /**
     * @param int $goalsTeamOne
     * @param int $goalsTeamTwo
     */
    protected function addGameToMatch($goalsTeamOne, $goalsTeamTwo)
    {
        $game = new Game();
        $game->setGoalsTeamOne($goalsTeamOne);
        $game->setGoalsTeamTwo($goalsTeamTwo);
        $this->match->addGame($game);
    }

}
