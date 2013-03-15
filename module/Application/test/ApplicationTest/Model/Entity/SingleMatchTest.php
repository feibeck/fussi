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
use Application\Model\Entity\SingleMatch;

/**
 * @covers Application\Model\Entity\SingleMatch
 * @covers Application\Model\Entity\Match
 */
class SingleMatchTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var SingleMatch
     */
    protected $match;

    public function setUp()
    {
        $this->match = new SingleMatch();
    }

    public function testPlayer1Property()
    {
        $player = new Player();
        $this->match->setPlayer1($player);
        $this->assertSame($player, $this->match->getPlayer1());
    }

    public function testPlayer2Property()
    {
        $player = new Player();
        $this->match->setPlayer2($player);
        $this->assertSame($player, $this->match->getPlayer2());
    }

    public function testPlayedBy()
    {
        $player1 = new Player();
        $player2 = new Player();
        $this->match->setPlayer1($player1);
        $this->match->setPlayer2($player2);
        $this->assertTrue($this->match->isPlayedBy($player1, $player2));
    }

    public function testPlayedByReversed()
    {
        $player1 = new Player();
        $player2 = new Player();
        $this->match->setPlayer1($player1);
        $this->match->setPlayer2($player2);
        $this->assertTrue($this->match->isPlayedBy($player2, $player1));
    }

    public function testNotPlayedBy()
    {
        $player1 = new Player();
        $player2 = new Player();
        $player3 = new Player();
        $this->match->setPlayer1($player1);
        $this->match->setPlayer2($player2);
        $this->assertFalse($this->match->isPlayedBy($player1, $player3));
    }

}
