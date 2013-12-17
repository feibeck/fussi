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
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers Application\Model\Entity\PointLog
 */
class PointLogTest extends TestCase
{

    /**
     * @var Player[]
     */
    protected $player = array();

    /**
     * @var DoubleMatch
     */
    protected $match;

    public function setUp()
    {
        $this->player[] = $this->createPlayer(1);
        $this->player[] = $this->createPlayer(2);
        $this->player[] = $this->createPlayer(3);
        $this->player[] = $this->createPlayer(4);

        $this->match = new DoubleMatch();
        $this->match->setTeamOne($this->player[0], $this->player[1]);
        $this->match->setTeamTwo($this->player[2], $this->player[3]);
    }

    public function testIdProperty()
    {
        $entity = new PointLog($this->match);
        $entity->setId(4);
        $this->assertEquals(4, $entity->getId());
    }

    public function testGetCurrentPoints()
    {
        $this->player[1]->setPoints(2000);
        $entity = new PointLog($this->match);
        $this->assertEquals(array(1500, 1000), array($entity->getCurrentPoints1(), $entity->getCurrentPoints2()));
    }

    public function testChanceProperty()
    {
        $entity = new PointLog($this->match);
        $entity->setChance1(70);
        $entity->setChance2(30);
        $actual = array($entity->getChance1(), $entity->getChance2());
        $this->assertEquals(array(70, 30), $actual);
    }

    public function testChanceForPlayer()
    {
        $entity = new PointLog($this->match);
        $entity->setChance1(40);
        $entity->setChance2(60);
        $actual = array($entity->getChance($this->player[0]), $entity->getChance($this->player[2]));
        $expected = array(40, 60);
        $this->assertEquals($expected, $actual);
    }

    public function testNewPoints()
    {
        $entity = new PointLog($this->match);
        $entity->setNewPoints1(1010);
        $entity->setNewPoints2(990);
        $actual = array($entity->getDifference1(), $entity->getDifference2());
        $this->assertEquals(array(10, -10), $actual);
    }

    public function testAddPlayerLogs()
    {
        $entity = new PointLog($this->match);
        $entity->addPlayerLog(new PointLogPlayer());
        $entity->addPlayerLog(new PointLogPlayer());
    }

    public function testNewPointsForPlayer()
    {
        $entity = new PointLog($this->match);
        $entity->setNewPoints1(980);
        $entity->setNewPoints2(1020);
        $actual = array($entity->getDifference($this->player[1]), $entity->getDifference($this->player[3]));
        $this->assertEquals(array(-20, 20), $actual);
    }

    public function testMatchGetter()
    {
        $entity = new PointLog($this->match);
        $this->assertSame($this->match, $entity->getMatch());
    }

    public function testSingleMatch()
    {
        $this->player[0]->setPoints(545);
        $this->player[1]->setPoints(1890);
        $match = new SingleMatch();
        $match->setPlayer1($this->player[0]);
        $match->setPlayer2($this->player[1]);
        $entity = new PointLog($match);
        $actual = array($entity->getCurrentPoints1(), $entity->getCurrentPoints2());
        $this->assertEquals(array(545, 1890), $actual);
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
