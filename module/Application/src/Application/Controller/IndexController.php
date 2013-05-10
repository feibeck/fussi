<?php
/**
 * Definition of Application\Controller\IndexController
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

use Application\Model\LeaguePeriod;
use Zend\Mvc\Controller\AbstractActionController;

use Application\Model\Ranking;
use Application\Model\Repository\TournamentRepository;
use Application\Model\Repository\MatchRepository;
use Application\Model\Entity\Tournament;

use \Datetime;

/**
 * Controller displaying the monthly view of a league tournament
 */
class IndexController extends AbstractActionController
{

    /**
     * @var TournamentRepository
     */
    protected $tournamentRepository;

    /**
     * @var MatchRepository
     */
    protected $matchRepository;

    /**
     * @param MatchRepository      $matchRepository
     * @param TournamentRepository $tournamentRepository
     */
    public function __construct(
        MatchRepository      $matchRepository,
        TournamentRepository $tournamentRepository
    )
    {
        $this->matchRepository      = $matchRepository;
        $this->tournamentRepository = $tournamentRepository;
    }

    /**
     * @return array
     */
    public function indexAction()
    {
        $year  = $this->params()->fromRoute('year');
        $month = $this->params()->fromRoute('month');
        $id    = $this->params()->fromRoute('id');

        /** @var $tournament \Application\Model\Entity\Tournament */
        $tournament = $this->tournamentRepository->find($id);

        $leaguePeriod = new LeaguePeriod($tournament->getStart(), $year, $month);
        if ($leaguePeriod->isOutOfBounds()) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $matches = $this->matchRepository->findForPeriod($tournament, $leaguePeriod);

        $players = $tournament->getPlayers();
        $activePlayers = $this->matchRepository->getActivePlayers($tournament, $leaguePeriod);

        if (!$leaguePeriod->inCurrentMonth()) {
            $players = $activePlayers;
        }

        $ranking = new Ranking($matches);

        $infoMaxPoints = (count($players) - 1) * 2;
        $infoMaxMatches = (count($players) - 1);
        $tournamentPotential =  $ranking->getPotential(count($players)-1);

        $infoMaxPoints = ($infoMaxPoints >= 0) ? $infoMaxPoints : 0;
        $infoMaxMatches = ($infoMaxMatches >= 0) ? $infoMaxMatches : 0;

        return array(
            'period'        => $leaguePeriod,
            'players'       => $players,
            'activePlayers' => $activePlayers,
            'matches'       => $matches,
            'ranking'       => $ranking,
            'tournament'    => $tournament,
            'infoMaxPoints'       => $infoMaxPoints,
            'infoMaxMatches'      => $infoMaxMatches,
            'tournamentPotential' => $tournamentPotential
        );

    }

}
