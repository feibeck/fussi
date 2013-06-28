<?php
/**
 * Fußi
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace ApplicationTest\Model;

use Application\Model\Team;
use Application\Model\Entity\Player;

class TeamTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Player
     */
    protected $player1;

    /**
     * @var Player
     */
    protected $player2;

    /**
     * @var Team
     */
    protected $team;

    public function setUp()
    {
        $this->player1 = new Player();
        $this->player1->setName('Foo');
        $this->player2 = new Player();
        $this->player2->setName('Bar');

        $this->team = new Team($this->player1, $this->player2);
    }

    public function testTeamName()
    {
        $actual = $this->team->getName();
        $this->assertEquals('Foo / Bar', $actual);
    }

    public function testGetAttackingPlayer()
    {
        $actual = $this->team->getAttackingPlayer();
        $this->assertSame($this->player1, $actual);
    }

    public function testGetDefendingPlayer()
    {
        $actual = $this->team->getDefendingPlayer();
        $this->assertSame($this->player2, $actual);
    }

}
