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

namespace ApplicationTest\Entity;

use Application\Entity\Player;
use ApplicationTest\Entity\Constraint\Player as PlayerConstraint;

/**
 * @covers Application\Entity\Player
 */
class PlayerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Player
     */
    protected $player;

    public function setUp()
    {
        $this->player = new Player();
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

    public function testGetArrayCopy()
    {
        $this->player->setId(2);
        $this->player->setName("Bar");
        $this->assertEquals(
            array('id' => 2, 'name' => 'Bar'),
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