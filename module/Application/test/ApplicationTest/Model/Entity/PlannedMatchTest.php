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

use Application\Model\Entity\PlannedMatch;
use PHPUnit_Framework_TestCase as TestCase;

class PlannedMatchTest extends TestCase
{

    /**
     * @var PlannedMatch
     */
    protected $plannedMatch;

    public function setUp()
    {
        $this->plannedMatch = new PlannedMatch();
    }

    public function testIdProperty()
    {
        $this->plannedMatch->setId(42);
        $this->assertEquals(42, $this->plannedMatch->getId());
    }

    public function testTournamentProperty()
    {
        $tournament = $this->getMock('Application\Model\Entity\Tournament');
        $this->plannedMatch->setTournament($tournament);
        $this->assertSame($tournament, $this->plannedMatch->getTournament());
    }

    public function testTeamOneProperty()
    {
        $team = $this->getMock('Application\Model\Entity\Team');
        $this->plannedMatch->setTeam1($team);
        $this->assertSame($team, $this->plannedMatch->getTeam1());
    }

    public function testTeamTwoProperty()
    {
        $team = $this->getMock('Application\Model\Entity\Team');
        $this->plannedMatch->setTeam2($team);
        $this->assertSame($team, $this->plannedMatch->getTeam2());
    }

    public function testSetTeamByIndexZero()
    {
        $team = $this->getMock('Application\Model\Entity\Team');
        $this->plannedMatch->setTeam($team, 0);
        $this->assertSame($team, $this->plannedMatch->getTeam1());
    }

    public function testSetTeamByIndexOne()
    {
        $team = $this->getMock('Application\Model\Entity\Team');
        $this->plannedMatch->setTeam($team, 1);
        $this->assertSame($team, $this->plannedMatch->getTeam2());
    }

    /**
     * @expectedException RuntimeException
     */
    public function testSetTeamByInvalidIndex()
    {
        $team = $this->getMock('Application\Model\Entity\Team');
        $this->plannedMatch->setTeam($team, 2);
    }

    public function testGetTeamByIndexZero()
    {
        $team = $this->getMock('Application\Model\Entity\Team');
        $this->plannedMatch->setTeam1($team);
        $this->assertSame($team, $this->plannedMatch->getTeam(0));
    }

    public function testGetTeamByIndexOne()
    {
        $team = $this->getMock('Application\Model\Entity\Team');
        $this->plannedMatch->setTeam2($team);
        $this->assertSame($team, $this->plannedMatch->getTeam(1));
    }

    /**
     * @expectedException RuntimeException
     */
    public function testGetTeamByInvalidIndex()
    {
        $this->plannedMatch->getTeam(2);
    }

    public function testConstructor()
    {
        $team1 = $this->getMock('Application\Model\Entity\Team');
        $team2 = $this->getMock('Application\Model\Entity\Team');

        $plannedMatch = new PlannedMatch($team1, $team2);

        $this->assertSame($team1, $plannedMatch->getTeam1());
        $this->assertSame($team2, $plannedMatch->getTeam2());
    }

    public function testGetTeam1NameWithoutTeam()
    {
        $this->assertEquals("", $this->plannedMatch->getTeam1Name());
    }

    public function testGetTeam1Name()
    {
        $team = $this->getMock('Application\Model\Entity\Team', array('getName'));
        $team->expects($this->once())->method('getName')->will($this->returnValue('Foo'));
        $this->plannedMatch->setTeam1($team);
        $this->assertEquals("Foo", $this->plannedMatch->getTeam1Name());
    }

    public function testGetTeam2NameWithoutTeam()
    {
        $this->assertEquals("", $this->plannedMatch->getTeam2Name());
    }

    public function testGetTeam2Name()
    {
        $team = $this->getMock('Application\Model\Entity\Team', array('getName'));
        $team->expects($this->once())->method('getName')->will($this->returnValue('Foo'));
        $this->plannedMatch->setTeam2($team);
        $this->assertEquals("Foo", $this->plannedMatch->getTeam2Name());
    }

    public function testRoundProperty()
    {
        $round = $this->getMock('Application\Model\Entity\Round');
        $this->plannedMatch->setRound($round);
        $this->assertSame($round, $this->plannedMatch->getRound());
    }

    public function testMatchProperty()
    {
        $match = $this->getMock('Application\Model\Entity\DoubleMatch');
        $this->plannedMatch->matchPlayed($match);
        $this->assertSame($match, $this->plannedMatch->getPlayedMatch());
    }

    public function testPlannedMatchIsNotPlayed()
    {
        $this->assertFalse($this->plannedMatch->isPlayed());
    }

    public function testPlannedMatchIsPlayed()
    {
        $match = $this->getMock('Application\Model\Entity\DoubleMatch');
        $this->plannedMatch->matchPlayed($match);
        $this->assertTrue($this->plannedMatch->isPlayed());
    }

    public function testPlannedMatchIsReady()
    {
        $team1 = $this->getMock('Application\Model\Entity\Team');
        $team2 = $this->getMock('Application\Model\Entity\Team');
        $this->plannedMatch->setTeam1($team1);
        $this->plannedMatch->setTeam2($team2);
        $this->assertTrue($this->plannedMatch->isReady());
    }

    public function testMatchWithoutTeamsIsNotReady()
    {
        $this->assertFalse($this->plannedMatch->isReady());
    }

    public function testPlannedMatchWithOneTeamIsNotReady()
    {
        $team1 = $this->getMock('Application\Model\Entity\Team');
        $this->plannedMatch->setTeam1($team1);
        $this->assertFalse($this->plannedMatch->isReady());
    }

    public function testPlayedPlannedMatchIsNotReady()
    {
        $team1 = $this->getMock('Application\Model\Entity\Team');
        $team2 = $this->getMock('Application\Model\Entity\Team');
        $this->plannedMatch->setTeam1($team1);
        $this->plannedMatch->setTeam2($team2);
        $match = $this->getMock('Application\Model\Entity\DoubleMatch');
        $this->plannedMatch->matchPlayed($match);
        $this->assertFalse($this->plannedMatch->isReady());
    }

    public function testWinner()
    {
        $match = $this->getMock('Application\Model\Entity\PlannedMatch');
        $this->plannedMatch->winnerPlaysInMatchAt($match, 1);
        $this->assertEquals(1, $this->plannedMatch->getMatchIndexForWinner());
        $this->assertSame($match, $this->plannedMatch->getMatchForWinner());
    }

    public function testIsFinal()
    {
        $this->assertTrue($this->plannedMatch->isFinal());
    }

    public function testIsNotFinal()
    {
        $match = $this->getMock('Application\Model\Entity\PlannedMatch');
        $this->plannedMatch->winnerPlaysInMatchAt($match, 1);
        $this->assertFalse($this->plannedMatch->isFinal());
    }

}
