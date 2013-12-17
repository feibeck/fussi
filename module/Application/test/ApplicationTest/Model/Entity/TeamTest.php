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

use Application\Model\Entity\Team;
use ApplicationTest\Model\Entity\Helper\PlayerHelper;
use \PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers Application\Model\Entity\Team
 */
class TeamTest extends TestCase
{

    /**
     * @var Team
     */
    protected $team;

    /**
     * @var PlayerHelper
     */
    protected $player;

    public function setUp()
    {
        $this->team = new Team();

        $this->player = new PlayerHelper();
        $this->player->createPlayer();
        $this->player->createPlayer();

        $this->team->setPlayer1($this->player[0]);
        $this->team->setPlayer2($this->player[1]);
    }

    public function testIdProperty()
    {
        $this->team->setId(4);
        $this->assertEquals(4, $this->team->getId());
    }

    public function testPlayer1Property()
    {
        $this->assertSame($this->player[0], $this->team->getPlayer1());
    }

    public function testPlayer2Property()
    {
        $this->assertSame($this->player[1], $this->team->getPlayer2());
    }

    public function testGetName()
    {
        $this->player[0]->setName('Foo');
        $this->player[1]->setName('Bar');
        $this->assertEquals('Foo / Bar', $this->team->getName());
    }

    public function testTournamentProperty()
    {
        $tournament = $this->getMock('\Application\Model\Entity\Tournament', array(), array(), '', false);
        $this->team->setTournament($tournament);
        $this->assertSame($tournament, $this->team->getTournament());
    }

}