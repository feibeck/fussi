<?php
/**
 * Definition of ApplicationTest\Entity\PointLogTest
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

use Application\Model\Entity\DoubleMatch;
use Application\Model\Entity\Player;
use Application\Model\Entity\PointLog;
use Application\Model\Entity\PointLogPlayer;
use Application\Model\Entity\SingleMatch;
use ApplicationTest\Model\Entity\Helper\PlayerHelper;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers Application\Model\Entity\PointLog
 */
class PointLogTest extends TestCase
{

    /**
     * @var PlayerHelper
     */
    protected $player;

    /**
     * @var DoubleMatch
     */
    protected $match;

    /**
     * @var PointLog
     */
    protected $pointLog;

    public function setUp()
    {
        $this->player = new PlayerHelper();
        $this->player->createPlayer();
        $this->player->createPlayer();
        $this->player->createPlayer();
        $this->player->createPlayer();

        $this->match = new DoubleMatch();
        $this->match->setTeamOne($this->player[0], $this->player[1]);
        $this->match->setTeamTwo($this->player[2], $this->player[3]);

        $this->pointLog = new PointLog($this->match);
    }

    public function testIdProperty()
    {
        $this->pointLog->setId(4);
        $this->assertEquals(4, $this->pointLog->getId());
    }

    public function testGetCurrentPoints()
    {
        $this->player[1]->setPoints(2000);
        $pointLog = new PointLog($this->match);

        $actual = array($pointLog->getCurrentPoints1(), $pointLog->getCurrentPoints2());
        $this->assertEquals(array(1500, 1000), $actual);
    }

    public function testChanceProperty()
    {
        $this->pointLog->setChance1(70);
        $this->pointLog->setChance2(30);
        $actual = array($this->pointLog->getChance1(), $this->pointLog->getChance2());
        $this->assertEquals(array(70, 30), $actual);
    }

    public function testChanceForPlayer()
    {
        $this->pointLog->setChance1(40);
        $this->pointLog->setChance2(60);
        $actual = array($this->pointLog->getChance($this->player[0]), $this->pointLog->getChance($this->player[2]));
        $expected = array(40, 60);
        $this->assertEquals($expected, $actual);
    }

    public function testNewPoints()
    {
        $this->pointLog->setNewPoints1(1010);
        $this->pointLog->setNewPoints2(990);
        $actual = array($this->pointLog->getDifference1(), $this->pointLog->getDifference2());
        $this->assertEquals(array(10, -10), $actual);
    }

    public function testAddPlayerLogs()
    {
        $this->pointLog->addPlayerLog(new PointLogPlayer());
        $this->pointLog->addPlayerLog(new PointLogPlayer());
    }

    public function testNewPointsForPlayer()
    {
        $this->pointLog->setNewPoints1(980);
        $this->pointLog->setNewPoints2(1020);
        $actual = array(
            $this->pointLog->getDifference($this->player[1]),
            $this->pointLog->getDifference($this->player[3])
        );
        $this->assertEquals(array(-20, 20), $actual);
    }

    public function testMatchGetter()
    {
        $this->assertSame($this->match, $this->pointLog->getMatch());
    }

    public function testSingleMatch()
    {
        $this->player[0]->setPoints(545);
        $this->player[1]->setPoints(1890);
        $match = new SingleMatch();
        $match->setPlayer1($this->player[0]);
        $match->setPlayer2($this->player[1]);
        $pointLog = new PointLog($match);
        $actual = array($pointLog->getCurrentPoints1(), $pointLog->getCurrentPoints2());
        $this->assertEquals(array(545, 1890), $actual);
    }

}