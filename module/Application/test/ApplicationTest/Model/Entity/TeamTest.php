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

use Application\Model\Entity\Player;
use Application\Model\Entity\Team;
use \PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers Application\Model\Entity\Team
 */
class TeamTest extends TestCase
{

    public function testIdProperty()
    {
        $team = new Team();
        $team->setId(4);
        $this->assertEquals(4, $team->getId());
    }

    public function testPlayer1Property()
    {
        $team = new Team();
        $player = $this->createPlayer(2);
        $team->setPlayer1($player);
        $this->assertSame($player, $team->getPlayer1());
    }

    public function testPlayer2Property()
    {
        $team = new Team();
        $player = $this->createPlayer(2);
        $team->setPlayer2($player);
        $this->assertSame($player, $team->getPlayer2());
    }

    public function testGetName()
    {
        $team = new Team();
        $team->setPlayer1($this->createPlayer(1));
        $team->setPlayer2($this->createPlayer(2));
        $team->getPlayer1()->setName('Foo');
        $team->getPlayer2()->setName('Bar');
        $this->assertEquals('Foo / Bar', $team->getName());
    }

    public function testTournamentProperty()
    {
        $team = new Team();
        $tournament = $this->getMock('\Application\Model\Entity\Tournament', array(), array(), '', false);
        $team->setTournament($tournament);
        $this->assertSame($tournament, $team->getTournament());
    }

    /**
     * @param int $id
     *
     * @return Player
     */
    protected function createPlayer($id)
    {
        $player = new Player();
        $player->setId($id);
        return $player;
    }


}