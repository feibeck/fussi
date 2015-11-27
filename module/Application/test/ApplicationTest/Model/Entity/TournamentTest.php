<?php
/**
 * Definition of ApplicationTest\Entity\TournamentTest
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

use Application\Model\Entity\Tournament;
use ApplicationTest\Model\Entity\Constraint\Tournament as TournamentConstraint;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers Application\Model\Entity\Tournament
 */
class TournamentTest extends TestCase
{

    /**
     * @var \Application\Model\Entity\Tournament
     */
    protected $tournament;

    public function setUp()
    {
        $this->tournament = new Tournament();
    }

    public function testGetArrayCopy()
    {
        $this->tournament->setId(1);
        $this->tournament->setName('Foo');
        $this->tournament->setGamesPerMatch(2);
        $this->assertEquals(
            array(
                'id'              => 1,
                'name'            => 'Foo',
                'games-per-match' => 2,
                'max-score'       => 10
            ),
            $this->tournament->getArrayCopy()
        );
    }

    public function testExchangeArray()
    {
        $this->tournament->exchangeArray(
            array(
                'id' => 42,
                'name' => 'Foo',
                'games-per-match' => 2,
                'max-score' => 7
            )
        );

        $expected = new Tournament();
        $expected->setId(42);
        $expected->setName('Foo');
        $expected->setGamesPerMatch(2);
        $expected->setMaxScore(7);

        $this->assertEquals($expected, $this->tournament);
    }

    public function testTournamentTypeName()
    {
        $this->assertEquals('Tournament', $this->tournament->getType());
    }

}
