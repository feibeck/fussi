<?php
/**
 * Definition of Application\Controller\DashboardController
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Controller;

use Application\Model\Repository\MatchRepository;
use Application\Model\Repository\TournamentRepository;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Controller for the dashboard (homepage)
 */
class DashboardController extends AbstractActionController
{

    /**
     * @var \Application\Model\Repository\MatchRepository
     */
    protected $matchRepository;

    /**
     * @var \Application\Model\Repository\TournamentRepository
     */
    protected $tournamentRepository;

    /**
     * @param \Application\Model\Repository\MatchRepository      $matchRepository
     * @param \Application\Model\Repository\TournamentRepository $tournamentRepository
     */
    public function __construct(
        MatchRepository $matchRepository,
        TournamentRepository $tournamentRepository
    )
    {
        $this->matchRepository = $matchRepository;
        $this->tournamentRepository = $tournamentRepository;
    }

    /**
     * @return array
     */
    public function dashboardAction()
    {
        return array(
            'matches' => $this->matchRepository->getLastMatches(),
            'tournaments' => $this->tournamentRepository->findAll()
        );
    }

}
