<?php
/**
 * Definition of ApplicationTest\Entity\TournamentTest
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

use Application\Model\Entity\Tournament;
use ApplicationTest\Model\Entity\Constraint\Tournament as TournamentConstraint;

/**
 * @covers Application\Model\Entity\Tournament
 */
class TournamentTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Application\Model\Entity\Tournament
     */
    protected $tournament;

    public function setUp()
    {
        $this->tournament = new Tournament();
    }

    public function testIdProperty()
    {
        $this->tournament->setId(1);
        $this->assertEquals(1, $this->tournament->getId());
    }

    public function testNameProperty()
    {
        $this->tournament->setName('Foo');
        $this->assertEquals('Foo', $this->tournament->getName());
    }

    public function testTeamTypeProperty()
    {
        $this->tournament->setTeamType(Tournament::TYPE_TEAM);
        $this->assertEquals(
            \Application\Model\Entity\Tournament::TYPE_TEAM, $this->tournament->getTeamType());
    }

    public function testIsSinglePlayer()
    {
        $this->tournament->setTeamType(\Application\Model\Entity\Tournament::TYPE_SINGLE);
        $this->assertTrue($this->tournament->isSinglePlayer());
        $this->assertFalse($this->tournament->isTeams());
    }

    public function testIsTeams()
    {
        $this->tournament->setTeamType(Tournament::TYPE_TEAM);
        $this->assertFalse($this->tournament->isSinglePlayer());
        $this->assertTrue($this->tournament->isTeams());
    }

    public function testGamesPerMatchProperty()
    {
        $this->tournament->setGamesPerMatch(3);
        $this->assertEquals(3, $this->tournament->getGamesPerMatch());
    }

    public function testStartProperty()
    {
        $date = new \DateTime('1994-04-05');
        $this->tournament->setStart($date);
        $this->assertSame($date, $this->tournament->getStart());
    }

    public function testEmptyPlayers()
    {
        $players = $this->tournament->getPlayers();
        $this->assertInstanceOf(
            '\Doctrine\Common\Collections\ArrayCollection',
            $players
        );
        $this->assertEquals(0, count($players));
    }

    public function testPlayers()
    {
        $player1 = $this->getMock('\Application\Model\Entity\Player');
        $player2 = $this->getMock('\Application\Model\Entity\Player');
        $this->tournament->addPlayer($player1);
        $this->tournament->addPlayer($player2);
        $players = $this->tournament->getPlayers();
        $this->assertSame($player1, $players[0]);
        $this->assertSame($player2, $players[1]);
    }

    public function testGetArrayCopy()
    {
        $this->tournament->setId(1);
        $this->tournament->setName('Foo');
        $this->tournament->setGamesPerMatch(2);
        $this->tournament->setTeamType(1);
        $this->tournament->setStart(new \DateTime('1994-04-05'));
        $this->assertEquals(
            array(
                'id' => 1,
                'name' => 'Foo',
                'team-type' => 1,
                'start-date' => new \DateTime('1994-04-05'),
                'games-per-match' => 2,
            ),
            $this->tournament->getArrayCopy()
        );
    }

    public function testExchangeArrayWithEmptyArray()
    {
        $this->tournament->exchangeArray(array());
        $this->assertThat(
            $this->tournament,
            new TournamentConstraint(null, null, 1, new \DateTime(), 0)
        );
    }

    public function testExchangeArray()
    {
        $this->tournament->exchangeArray(
            array(
                'id' => 42,
                'name' => 'Foo',
                'games-per-match' => 2,
                'start-date' => new \DateTime('1994-05-04'),
                'team-type' => 1
            )
        );
        $this->assertThat(
            $this->tournament,
            new TournamentConstraint(42, 'Foo', 2, new \DateTime('1994-05-04'), 1)
        );
    }

}
