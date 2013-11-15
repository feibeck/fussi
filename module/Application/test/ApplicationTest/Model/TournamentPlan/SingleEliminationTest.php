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

namespace ApplicationTest\Model\TournamentPlan;

use Application\Model\Entity\Team;
use Application\Model\Entity\Round;
use Application\Model\TournamentPlan\SingleElimination;
use \PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers \Application\Model\TournamentPlan\SingleElimination
 */
class SingleEliminationTest extends TestCase
{

    public function testGamesWithThreeTeams()
    {
        $rounds = $this->getRoundsFromPlan(3);

        $this->assertEquals(2, count($rounds));

        $gamecount = array(
            $rounds[0]->getMatchCount(),
            $rounds[1]->getMatchCount(),
        );

        $this->assertEquals(
            array(0 => 1, 1 => 1),
            $gamecount
        );
    }

    public function testGamesWithFourTeams()
    {
        $rounds = $this->getRoundsFromPlan(4);

        $this->assertEquals(2, count($rounds));

        $gamecount = array(
            $rounds[0]->getMatchCount(),
            $rounds[1]->getMatchCount(),
        );

        $this->assertEquals(
            array(0 => 2, 1 => 1),
            $gamecount
        );
    }

    public function testGamesWithFiveTeams()
    {
        $rounds = $this->getRoundsFromPlan(5);

        $this->assertEquals(3, count($rounds));

        $gamecount = array(
            $rounds[0]->getMatchCount(),
            $rounds[1]->getMatchCount(),
            $rounds[2]->getMatchCount(),
        );

        $this->assertEquals(
            array(0 => 1, 1 => 2, 2 => 1),
            $gamecount
        );
    }

    public function testGamesWithSixTeams()
    {
        $rounds = $this->getRoundsFromPlan(6);

        $this->assertEquals(3, count($rounds));

        $gamecount = array(
            $rounds[0]->getMatchCount(),
            $rounds[1]->getMatchCount(),
            $rounds[2]->getMatchCount(),
        );

        $this->assertEquals(
            array(0 => 2, 1 => 2, 2 => 1),
            $gamecount
        );
    }

    public function testGamesWithEightTeams()
    {
        $rounds = $this->getRoundsFromPlan(8);

        $this->assertEquals(3, count($rounds));

        $gamecount = array(
            $rounds[0]->getMatchCount(),
            $rounds[1]->getMatchCount(),
            $rounds[2]->getMatchCount(),
        );

        $this->assertEquals(
            array(0 => 4, 1 => 2, 2 => 1),
            $gamecount
        );
    }

    /**
     * @param $teamCount
     *
     * @return Round[]
     */
    protected function getRoundsFromPlan($teamCount)
    {
        $teams = array_fill(0, $teamCount, new Team());
        $plan = new SingleElimination();
        $rounds = $plan->init($teams);
        return $rounds;
    }

}