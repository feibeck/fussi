<?php
/**
 * Definition of ApplicationTest\Entity\PointLogPlayerTest
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
use Application\Model\Entity\PointLogPlayer;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers Application\Model\Entity\PointLogPlayer
 */
class PointLogPlayerTest extends TestCase
{

    public function testIdProperty()
    {
        $entity = new PointLogPlayer();
        $entity->setId(4);
        $this->assertEquals(4, $entity->getId());
    }

    public function testPointsAfterProperty()
    {
        $entity = new PointLogPlayer();
        $entity->setPointsAfter(199);
        $this->assertEquals(199, $entity->getPointsAfter());
    }

    public function testPointsBeforeProperty()
    {
        $entity = new PointLogPlayer();
        $entity->setPointsBefore(199);
        $this->assertEquals(199, $entity->getPointsBefore());
    }

    public function testPlayerProperty()
    {
        $entity = new PointLogPlayer();
        $player = new Player();
        $entity->setPlayer($player);
        $this->assertSame($player, $entity->getPlayer());
    }

    public function testPointLogProperty()
    {
        $entity = new PointLogPlayer();
        $log = $this->getMock('Application\Model\Entity\PointLog', array(), array(), '', false);
        $entity->setPointLog($log);
        $this->assertSame($log, $entity->getPointLog());
    }

}
