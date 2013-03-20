<?php
/**
 * Definition of Application\Model\PlayerRanking
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Model;

use \DateTime;

class LeaguePeriod
{

    /**
     * @var DateTime
     */
    private $start;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var DateTime
     */
    private $now;

    /**
     * @param DateTime $start
     * @param int       $year
     * @param int       $month
     */
    public function __construct(DateTime $start, $year, $month)
    {
        $this->start = clone $start;
        $this->start->modify('first day of');
        $this->start->setTime(0, 0, 0);

        $this->date = new DateTime();
        $this->date->setDate($year, $month, 1);
        $this->date->setTime(0, 0, 0);

        $this->now = new DateTime();
        $this->now->setTime(0, 0, 0);
        $this->now->modify('first day of');
    }

    /**
     * @return bool
     */
    public function isOutOfBounds()
    {
        if ($this->date > $this->now || $this->date < $this->start) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function inCurrentMonth()
    {
        return $this->now->format('Ym') == $this->date->format('Ym');
    }

    /**
     * @return DateTime
     */
    public function getStart()
    {
        return $this->date;
    }

    /**
     * @return DateTime
     */
    public function getEnd()
    {
        $end = clone $this->date;
        $end->setTime(23, 59, 59);
        $end->modify('last day of');
        return $end;
    }

    /**
     * @return DateTime
     */
    public function getNext()
    {
        $next = clone($this->date);
        $next->modify("+1 month");
        return $next;
    }

    /**
     * @return DateTime
     */
    public function getPrevious()
    {
        $prev = clone($this->date);
        $prev->modify("-1 month");
        return $prev;
    }

    public function hasPrevious()
    {
        $prev = $this->getPrevious();
        return $prev >= $this->start;
    }

}
