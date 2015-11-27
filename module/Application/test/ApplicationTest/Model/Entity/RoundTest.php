<?php
/**
 * Definition of ApplicationTest\Entity\RoundTest
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

use Application\Model\Entity\PlannedMatch;
use Application\Model\Entity\Round;
use Application\Model\Entity\Tournament;
use PHPUnit_Framework_TestCase as TestCase;

class RoundTest extends TestCase
{

    /**
     * @var Round
     */
    protected $round;

    public function setUp()
    {
        $this->round = new Round();
    }

    public function testIdProperty()
    {
        $this->round->setId(5);
        $this->assertEquals(5, $this->round->getId());
    }

    public function testNewRoundHasNoMatches()
    {
        $this->assertEquals(0, $this->round->getMatchCount());
    }

    public function testAddMatchIncreasesCount()
    {
        $this->round->addMatch($this->createMatch());
        $this->assertEquals(1, $this->round->getMatchCount());
    }

    public function testMatchesAreReturned()
    {
        $matches = array(
            $this->createMatch(),
            $this->createMatch(),
        );
        $this->round->addMatch($matches[0]);
        $this->round->addMatch($matches[1]);
        $this->assertEquals($matches, $this->round->getMatches());
    }

    public function testSpecificMatchIsReturned()
    {
        $matches = array(
            $this->createMatch(),
            $this->createMatch(),
            $this->createMatch(),
        );
        $this->round->addMatch($matches[0]);
        $this->round->addMatch($matches[1]);
        $this->round->addMatch($matches[2]);
        $this->assertSame($matches[2], $this->round->getMatch(2));
    }

    public function testNoErrorOnRetrievingInvalidIndex()
    {
        $this->assertNull($this->round->getMatch(1));
    }

    public function testTournamentProperty()
    {
        $tournament = new Tournament();
        $this->round->setTournament($tournament);
        $this->assertSame($tournament, $this->round->getTournament());
    }

    public function testTournamentIsAddedToMatch()
    {
        $tournament = new Tournament();
        $this->round->setTournament($tournament);
        $this->round->addMatch($this->getMatchMock($tournament));
    }

    public function testTournamentIsAddedToAllMatch()
    {
        $tournament = new Tournament();

        $this->round->addMatch($this->getMatchMock($tournament));
        $this->round->addMatch($this->getMatchMock($tournament));

        $this->round->setTournament($tournament);
    }

    /**
     * @return PlannedMatch
     */
    protected function createMatch()
    {
        $match = new PlannedMatch();
        return $match;
    }

    /**
     * @param $tournament
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMatchMock($tournament)
    {
        $match = $this->getMock(
            '\Application\Model\Entity\PlannedMatch',
            array('setTournament')
        );
        $match->expects($this->once())
            ->method('setTournament')
            ->with($tournament);
        return $match;
    }

}
