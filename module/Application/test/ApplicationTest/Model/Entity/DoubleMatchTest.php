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

}
