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

use Application\Model\LeaguePeriod;

class LeaguePeriodTest extends \PHPUnit_Framework_TestCase
{

    public function testInCurrentMonth()
    {
        $today = new \DateTime();
        $period = $this->getPeriod($today);
        $this->assertTrue($period->inCurrentMonth());
    }

    public function testNotInCurrentMonth()
    {
        $today = new \DateTime();
        $today->modify("-1 month");
        $period = $this->getPeriod($today);
        $this->assertFalse($period->inCurrentMonth());
    }

    public function testIsBeforeStart()
    {
        $today = new \DateTime();
        $today->modify("-3 month");
        $period = $this->getPeriod($today);
        $this->assertTrue($period->isOutOfBounds());
    }

    public function testIsInFuture()
    {
        $today = new \DateTime();
        $today->modify("+1 month");
        $period = $this->getPeriod($today);
        $this->assertTrue($period->isOutOfBounds());
    }

    public function testIsInPeriodRange()
    {
        $today = new \DateTime();
        $today->modify("-1 month");
        $period = $this->getPeriod($today);
        $this->assertFalse($period->isOutOfBounds());
    }

    public function testStartIsReturned()
    {
        $period = new LeaguePeriod(new \DateTime(), 2013, 12);
        $this->assertSame('2013-12-01', $period->getStart()->format('Y-m-d'));
    }

    public function testEndIsReturned()
    {
        $period = new LeaguePeriod(new \DateTime(), 2013, 12);
        $this->assertSame('2013-12-31', $period->getEnd()->format('Y-m-d'));
    }

    public function testHasPrevious()
    {
        $start = new \DateTime('2013-01-01');
        $period = new LeaguePeriod($start, 2013, 02);
        $this->assertTrue($period->hasPrevious());
    }

    public function testNoPreviousInStartMonth()
    {
        $start = new \DateTime('2013-01-01');
        $period = new LeaguePeriod($start, 2013, 01);
        $this->assertFalse($period->hasPrevious());
    }

    public function testGetPrevious()
    {
        $start = new \DateTime('2013-01-01');
        $period = new LeaguePeriod($start, 2013, 02);
        $this->assertEquals("2013-01-01", $period->getPrevious()->format('Y-m-d'));
    }

    public function testGetNext()
    {
        $start = new \DateTime('2013-01-01');
        $period = new LeaguePeriod($start, 2013, 02);
        $this->assertEquals("2013-03-01", $period->getNext()->format('Y-m-d'));
    }

    /**
     * @param \DateTime $date
     *
     * @return LeaguePeriod
     */
    private function getPeriod($date)
    {
        $start = new \DateTime();
        $start->modify("-2 month");
        $start->modify("first day of");

        $period = new LeaguePeriod($start, $date->format('Y'), $date->format('m'));
        return $period;
    }

}
