<?php
/**
 * Definition of ApplicationTest\Entity\LeagueTest
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

use Application\Model\Entity\League;
use ApplicationTest\Model\Entity\Constraint\Tournament as TournamentConstraint;

/**
 * @covers Application\Model\Entity\League
 */
class LeagueTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Application\Model\Entity\League
     */
    protected $tournament;

    public function setUp()
    {
        $this->tournament = new League();
    }

    public function testGetArrayCopy()
    {
        $this->tournament->setId(1);
        $this->tournament->setName('Foo');
        $this->tournament->setGamesPerMatch(2);
        $this->tournament->setTeamType(1);
        $this->tournament->setStart(new \DateTime('1994-04-05'));
        $this->assertEquals(
            array(
                'id' => 1,
                'name' => 'Foo',
                'team-type' => 1,
                'start-date' => new \DateTime('1994-04-05'),
                'games-per-match' => 2,
                'max-score' => 10
            ),
            $this->tournament->getArrayCopy()
        );
    }

    public function testExchangeArrayWithEmptyArray()
    {
        $this->tournament->exchangeArray(array());
        $this->assertThat(
            $this->tournament,
            new TournamentConstraint(null, null, 1, new \DateTime(), 0)
        );
    }

    public function testExchangeArray()
    {
        $this->tournament->exchangeArray(
            array(
                'id' => 42,
                'name' => 'Foo',
                'games-per-match' => 2,
                'start-date' => new \DateTime('1994-05-04'),
                'team-type' => 1,
            )
        );
        $this->assertThat(
            $this->tournament,
            new TournamentConstraint(42, 'Foo', 2, new \DateTime('1994-05-04'), 1)
        );
    }

    public function testTournamentTypeName()
    {
        $this->assertEquals('League', $this->tournament->getType());
    }

}
