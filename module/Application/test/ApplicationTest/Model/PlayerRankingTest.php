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

use Application\Model\PlayerRanking;
use Application\Model\Entity\Player;

class PlayerRankingTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var PlayerRanking
     */
    protected $ranking;

    public function setUp()
    {
        $player = new Player();
        $this->ranking = new PlayerRanking($player);
    }

    public function testGoals()
    {
        $this->ranking->addGoals(5);
        $this->ranking->addGoals(2);
        $this->assertEquals(7, $this->ranking->getGoals());
    }

    public function testGoalsAgainst()
    {
        $this->ranking->addGoalsAgainst(3);
        $this->ranking->addGoalsAgainst(2);
        $this->assertEquals(5, $this->ranking->getGoalsAgainst());
    }

    public function testScore()
    {
        $this->ranking->addPoints(3);
        $this->ranking->addPoints(2);
        $this->assertEquals(5, $this->ranking->getScore());
    }

    public function testNumberOfMatches()
    {
        $this->ranking->addPoints(3);
        $this->ranking->addPoints(2);
        $this->assertEquals(2, $this->ranking->getMatchCount());
    }

    public function testPlayer()
    {
        $player = new Player();
        $ranking = new PlayerRanking($player);
        $this->assertSame($player, $ranking->getPlayer());
    }

}
