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

namespace ApplicationTest\Validator;

use Application\Model\Entity\AbstractTournament;
use Application\Validator\MatchMode;
use PHPUnit_Framework_TestCase as TestCase;

class MatchModeTest extends TestCase
{

    /**
     * @var MatchMode
     */
    protected $validator;

    public function setUp()
    {
        $this->validator = new MatchMode('foo');
    }

    public function testExactMatchMode()
    {
        $actual = $this->validator->isValid(1, array('foo' => AbstractTournament::MODE_EXACTLY));
        $this->assertTrue($actual);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testModeFieldNotFound()
    {
        $this->validator->isValid(1, array('bar' => AbstractTournament::MODE_EXACTLY));
    }

    public function testModeBestOfMinimum()
    {
        $actual = $this->validator->isValid(1, array('foo' => AbstractTournament::MODE_BEST_OF));
        $this->assertFalse($actual);
    }

    /**
     * @dataProvider provideEvenNumbers
     */
    public function testModeBestOfWithEvenNumbers($fixture)
    {
        $actual = $this->validator->isValid($fixture, array('foo' => AbstractTournament::MODE_BEST_OF));
        $this->assertFalse($actual);
    }

    public function provideEvenNumbers()
    {
        return array(
            array(2),
            array(4),
            array(6),
            array(28),
        );
    }

    /**
     * @dataProvider provideOddNumbers
     */
    public function testModeBestOfWithOddNumbers($fixture)
    {
        $actual = $this->validator->isValid($fixture, array('foo' => AbstractTournament::MODE_BEST_OF));
        $this->assertTrue($actual);
    }

    public function provideOddNumbers()
    {
        return array(
            array(3),
            array(5),
            array(7),
            array(29),
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testInvalidMatchMode()
    {
        $this->validator->isValid(23, array('foo' => '3'));
    }

}
