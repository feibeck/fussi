<?php
/**
 * Definition of Application\ViewHelper\LeaguePaginator
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\ViewHelper;

use Application\Model\Entity\Tournament;
use Application\Model\LeaguePeriod;
use Zend\View\Helper\AbstractHelper;
use \DateTime;

class LeaguePaginator extends AbstractHelper
{

    public function __invoke(Tournament $tournament, LeaguePeriod $period)
    {
        $html = '<ul class="pager">';
        $html .= '<li class="previous ' . ($period->hasPrevious() ? '' : 'disabled') . '">';
        $html .= '<a href="' . ($period->hasPrevious() ? $this->getUrl($tournament, $period->getPrevious()) : '#') . '">&larr; Older</a>';
        $html .= '</li>';
        $html .= '<li class="next ' . ($period->inCurrentMonth() ? 'disabled' : '') . '">';
        $html .= '<a href="' . ($period->inCurrentMonth() ? '#' : $this->getUrl($tournament, $period->getNext())) . '">Newer &rarr;</a>';
        $html .= '</li>';
        $html .= '</ul>';

        return $html;
    }

    /**
     * @param Tournament $tournament
     * @param DateTime   $date
     *
     * @return string
     */
    protected function getUrl(Tournament $tournament, DateTime $date)
    {
        return $this->view->url(
            'tournament/show',
            array(
                'id' => $tournament->getId(),
                'year' => $date->format('Y'),
                'month' => $date->format('m')
            )
        );
    }

}
