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

use Application\Model\Entity\SingleMatch;
use ApplicationTest\Model\Entity\Helper\PlayerHelper;

/**
 * @covers Application\Model\Entity\SingleMatch
 */
class SingleMatchTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var SingleMatch
     */
    protected $match;

    /**
     * @var PlayerHelper
     */
    protected $player;

    public function setUp()
    {
        $this->match = new SingleMatch();

        $this->player = new PlayerHelper();
        $this->player->createPlayer();
        $this->player->createPlayer();

        $this->match->setPlayer1($this->player[0]);
        $this->match->setPlayer2($this->player[1]);
    }

    public function testPlayer1Property()
    {
        $this->assertSame($this->player[0], $this->match->getPlayer1());
    }

    public function testPlayer2Property()
    {
        $this->assertSame($this->player[1], $this->match->getPlayer2());
    }

    public function testPlayedBy()
    {
        $this->assertTrue($this->match->isPlayedBy($this->player[0], $this->player[1]));
    }

    public function testPlayedByReversed()
    {
        $this->assertTrue($this->match->isPlayedBy($this->player[1], $this->player[0]));
    }

    public function testNotPlayedBy()
    {
        $this->player->createPlayer();
        $this->assertFalse($this->match->isPlayedBy($this->player[0], $this->player[2]));
    }

    public function testGetPlayer()
    {
        $this->assertEquals($this->player->player, $this->match->getPlayer());
    }

    public function testGetSideForPlayer1()
    {
        $this->assertEquals(1, $this->match->getSideForPlayer($this->player[0]));
    }

    public function testGetSideForPlayer()
    {
        $this->assertEquals(2, $this->match->getSideForPlayer($this->player[1]));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetSideForInvalidPlayer()
    {
        $this->match->getSideForPlayer($this->player->createPlayer());
    }

}