<?php
/**
 * Definition of Application\Controller\DashboardController
 *
 * @copyright Copyright (c) 2014 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Controller;

use Application\Model\MatchFeeder;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Controller handles all kind of possible feeds
 * For example: rss
 */
class FeedController extends AbstractActionController
{
    /**
     * @var MatchFeeder
     */
    protected $matchFeeder;

    /**
     * @param MatchFeeder $matchFeeder
     */
    public function __construct(MatchFeeder $matchFeeder)
    {
        $this->matchFeeder     = $matchFeeder;
    }

    public function lastMatchesAction()
    {
        $feed = $this->matchFeeder->generate();

        return $this->renderFeed($feed);
    }

    /**
     * @param $feed
     *
     * @return ViewModel
     */
    private function renderFeed($feed)
    {
        $view = new ViewModel(compact('feed'));
        $view->setTerminal(true);

        return $view;
    }
}
