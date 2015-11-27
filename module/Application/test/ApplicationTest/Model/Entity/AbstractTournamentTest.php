<?php
/**
 * Definition of ApplicationTest\Entity\AbstractTournamentTest
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

use Application\Model\Entity\AbstractTournament;
use ApplicationTest\Model\Entity\Helper\PlayerHelper;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers Application\Model\Entity\AbstractTournament
 */
class AbstractTournamentTest extends TestCase
{

    /**
     * @var \Application\Model\Entity\AbstractTournament
     */
    protected $tournament;

    public function setUp()
    {
        $this->tournament = $this->getMockForAbstractClass('\Application\Model\Entity\AbstractTournament');
    }

    public function testIdProperty()
    {
        $this->tournament->setId(5);
        $this->assertEquals(5, $this->tournament->getId());
    }

    public function testNameProperty()
    {
        $this->tournament->setName("Foo");
        $this->assertEquals("Foo", $this->tournament->getName());
    }

    public function testTeamTypeProperty()
    {
        $this->tournament->setTeamType(AbstractTournament::TYPE_TEAM);
        $this->assertEquals(AbstractTournament::TYPE_TEAM, $this->tournament->getTeamType());
    }

    public function testTeamTypeSingleIsSingle()
    {
        $this->tournament->setTeamType(AbstractTournament::TYPE_SINGLE);
        $this->assertTrue($this->tournament->isSinglePlayer());
    }

    public function testTeamTypeTeamIsNotSingle()
    {
        $this->tournament->setTeamType(AbstractTournament::TYPE_TEAM);
        $this->assertFalse($this->tournament->isSinglePlayer());
    }

    public function testTeamTypeTeamIsTeam()
    {
        $this->tournament->setTeamType(AbstractTournament::TYPE_TEAM);
        $this->assertTrue($this->tournament->isTeams());
    }

    public function testTeamTypeSingleIsNotTeam()
    {
        $this->tournament->setTeamType(AbstractTournament::TYPE_SINGLE);
        $this->assertFalse($this->tournament->isTeams());
    }

    public function testGamesPerMatchProperty()
    {
        $this->tournament->setGamesPerMatch(7);
        $this->assertEquals(7, $this->tournament->getGamesPerMatch());
    }

    public function testMaxScoreProperty()
    {
        $this->tournament->setMaxScore(34);
        $this->assertEquals(34, $this->tournament->getMaxScore());
    }

    public function testStartProperty()
    {
        $date = new \DateTime();
        $this->tournament->setStart($date);
        $this->assertSame($date, $this->tournament->getStart());
    }

    public function testStartDateGetsConvertedFromString()
    {
        $this->tournament->setStart("2013-01-01 05:30:00");
        $expected = new \DateTime("2013-01-01 05:30:00");
        $this->assertEquals($expected, $this->tournament->getStart());
    }

    public function testEndProperty()
    {
        $dateTime = new \DateTime();
        $this->tournament->setEnd($dateTime);
        $this->assertSame($dateTime, $this->tournament->getEnd());
    }

    public function testEndPropertyCanBeSetToNull()
    {
        $this->tournament->setEnd(null);
        $this->assertNull($this->tournament->getEnd());
    }

    public function testEndPropertyNoDateTimeWillSetNull()
    {
        $this->tournament->setEnd('aString');
        $this->assertNull($this->tournament->getEnd());
    }

    public function testMatchModeProperty()
    {
        $this->tournament->setMatchMode(AbstractTournament::MODE_EXACTLY);
        $this->assertEquals(AbstractTournament::MODE_EXACTLY, $this->tournament->getMatchMode());
    }

    public function testMatchModeExactlyIsExactly()
    {
        $this->tournament->setMatchMode(AbstractTournament::MODE_EXACTLY);
        $this->assertTrue($this->tournament->isMatchModeExactly());
    }

    public function testMatchModeBestOfIsNotExactly()
    {
        $this->tournament->setMatchMode(AbstractTournament::MODE_BEST_OF);
        $this->assertFalse($this->tournament->isMatchModeExactly());
    }

    public function testMatchModeBestOfIsBestOf()
    {
        $this->tournament->setMatchMode(AbstractTournament::MODE_BEST_OF);
        $this->assertTrue($this->tournament->isMatchModeBestOf());
    }

    public function testMatchModeExactlyIsNotBestOf()
    {
        $this->tournament->setMatchMode(AbstractTournament::MODE_EXACTLY);
        $this->assertFalse($this->tournament->isMatchModeBestOf());
    }

    public function testNewTournamentIsActive()
    {
        $this->assertTrue($this->tournament->isActive());
    }

    public function testEndedTournamentIsNotActive()
    {
        $this->tournament->setEnd(new \DateTime());
        $this->assertFalse($this->tournament->isActive());
    }

    public function testPlayerProperty()
    {
        $helper = new PlayerHelper();
        $this->tournament->addPlayer($helper->createPlayer());
        $this->tournament->addPlayer($helper->createPlayer());
        $this->assertEquals($helper->players, $this->tournament->getPlayers());
    }

    public function testMinimumNumberOfGamesForMatchModeExactly()
    {
        $this->tournament->setMatchMode(AbstractTournament::MODE_EXACTLY);
        $this->tournament->setGamesPerMatch(3);
        $this->assertEquals(3, $this->tournament->getMinimumNumberOfGames());
    }

    public function testMinimumNumberOfGamesForMatchModeBestOfThreeGames()
    {
        $this->tournament->setMatchMode(AbstractTournament::MODE_BEST_OF);
        $this->tournament->setGamesPerMatch(3);
        $this->assertEquals(2, $this->tournament->getMinimumNumberOfGames());
    }

    public function testMinimumNumberOfGamesForMatchModeBestOfSevenGames()
    {
        $this->tournament->setMatchMode(AbstractTournament::MODE_BEST_OF);
        $this->tournament->setGamesPerMatch(7);
        $this->assertEquals(4, $this->tournament->getMinimumNumberOfGames());
    }

}