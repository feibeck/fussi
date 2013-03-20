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

namespace ApplicationTest\ViewHelper;

use Application\ViewHelper\LeaguePaginator;

class LeaguePaginatorTest extends \PHPUnit_Framework_TestCase
{

    public function testPaginatorWithPreviousAndNext()
    {
        $tournament = new \Application\Model\Entity\Tournament();
        $period = $this->getPeriod(true, false);

        $helper = new LeaguePaginator();
        $helper->setView($this->getView());
        $html = $helper($tournament, $period);

        $expected = '<ul class="pager"><li class="previous "><a href="/foo/bar">&larr; Older</a></li><li class="next "><a href="/foo/bar">Newer &rarr;</a></li></ul>';
        $this->assertEquals($expected, $html);
    }

    public function testPaginatorOnStartMonth()
    {
        $tournament = new \Application\Model\Entity\Tournament();
        $period = $this->getPeriod(false, false);

        $helper = new LeaguePaginator();
        $helper->setView($this->getView());
        $html = $helper($tournament, $period);

        $expected = '<ul class="pager"><li class="previous disabled"><a href="#">&larr; Older</a></li><li class="next "><a href="/foo/bar">Newer &rarr;</a></li></ul>';
        $this->assertEquals($expected, $html);
    }

    public function testPaginatorOnLastMonth()
    {
        $tournament = new \Application\Model\Entity\Tournament();
        $period = $this->getPeriod(false, true);

        $helper = new LeaguePaginator();
        $helper->setView($this->getView());
        $html = $helper($tournament, $period);

        $expected = '<ul class="pager"><li class="previous disabled"><a href="#">&larr; Older</a></li><li class="next disabled"><a href="#">Newer &rarr;</a></li></ul>';
        $this->assertEquals($expected, $html);
    }

    private function getPeriod($hasPrevious, $hasNext)
    {
        $period = $this->getMock(
            '\Application\Model\LeaguePeriod',
            array(),
            array(),
            '',
            false
        );
        $period->expects($this->any())
            ->method('getNext')
            ->will($this->returnValue(new \DateTime('2013-03-01')));
        $period->expects($this->any())
            ->method('getPrevious')
            ->will($this->returnValue(new \DateTime('2013-01-01')));
        $period->expects($this->any())
            ->method('hasPrevious')
            ->will($this->returnValue($hasPrevious));
        $period->expects($this->any())
            ->method('inCurrentMonth')
            ->will($this->returnValue($hasNext));

        return $period;
    }

    private function getView()
    {
        $view = $this->getMock(
            '\Zend\View\Renderer\PhpRenderer',
            array(
                 'url'
            ),
            array(),
            '',
            false
        );

        $view->expects($this->any())
            ->method('url')
            ->will($this->returnValue('/foo/bar'));

        return $view;
    }

}
