<?php
/**
 * Definition of ApplicationTest\Entity\GameTest
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

use Application\Entity\Game;

/**
 * @covers Application\Entity\Game
 */
class GameTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Game
     */
    protected $game;

    public function setUp()
    {
        $this->game = new Game();
    }

    public function testIdProperty()
    {
        $this->game->setId(1);
        $this->assertEquals(1, $this->game->getId());
    }

    public function testMatchProperty()
    {
        $match = $this->getMock('Application\Entity\Match');
        $this->game->setMatch($match);
        $this->assertSame($match, $this->game->getMatch());
    }

    public function testGoalsTeamOneProperty()
    {
        $this->game->setGoalsTeamOne(1);
        $this->assertEquals(1, $this->game->getGoalsTeamOne());
    }

    public function testGoalsTeamTwoProperty()
    {
        $this->game->setGoalsTeamTwo(2);
        $this->assertEquals(2, $this->game->getGoalsTeamTwo());
    }

}
