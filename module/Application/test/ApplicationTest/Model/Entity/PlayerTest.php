<?php
/**
 * Definition of ApplicationTest\Entity\PlayerTest
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
use ApplicationTest\Model\Entity\Constraint\Player as PlayerConstraint;

/**
 * @covers Application\Model\Entity\Player
 */
class PlayerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Application\Model\Entity\Player
     */
    protected $player;

    public function setUp()
    {
        $this->player = new \Application\Model\Entity\Player();
    }

    public function testIdProperty()
    {
        $this->player->setId(1);
        $this->assertEquals(1, $this->player->getId());
    }

    public function testNameProperty()
    {
        $this->player->setName("Foo");
        $this->assertEquals("Foo", $this->player->getName());
    }

    public function testPointProperty()
    {
        $this->player->setPoints(400);
        $this->assertEquals(400, $this->player->getPoints());
    }

    public function testMatchCountProperty()
    {
        $this->player->setMatchCount(5);
        $this->player->incrementMatchCount();
        $this->assertEquals(6, $this->player->getMatchCount());
    }

    public function testGetArrayCopy()
    {
        $this->player->setId(2);
        $this->player->setName("Bar");
        $this->assertEquals(
            array('id' => 2, 'name' => 'Bar', 'points' => 1000, 'matchCount' => 0),
            $this->player->getArrayCopy()
        );
    }

    public function testExchangeArray()
    {
        $this->player->exchangeArray(array('id' => 2, 'name' => 'Bar'));
        $this->assertThat($this->player, new PlayerConstraint(2, 'Bar'));
    }

    public function testExchangeArrayWithEmptyArray()
    {
        $this->player->exchangeArray(array());
        $this->assertThat($this->player, new PlayerConstraint(null, null));
    }

}