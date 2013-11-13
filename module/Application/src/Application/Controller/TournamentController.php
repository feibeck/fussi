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

use Application\Model\Entity\League;
use Application\Model\Entity\Tournament;
use Application\Model\LeaguePeriod;
use Application\Model\Ranking;
use Application\Model\Repository\MatchRepository;
use Application\Model\Repository\TournamentRepository;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Controller displaying the monthly view of a league tournament
 */
class TournamentController extends AbstractActionController
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
     * @param TournamentRepository $tournamentRepository
     * @param MatchRepository      $matchRepository
     */
    public function __construct(TournamentRepository $tournamentRepository, MatchRepository $matchRepository)
    {
        $this->tournamentRepository = $tournamentRepository;
        $this->matchRepository = $matchRepository;
    }

    public function showAction()
    {
        $id = $this->params()->fromRoute('id');

        /** @var $tournament \Application\Model\Entity\League */
        $tournament = $this->tournamentRepository->find($id);

        if ($tournament instanceof League) {
            return $this->handleLeague($tournament);
        } elseif ($tournament instanceof Tournament) {
            return $this->handleTournament($tournament);
        }
    }

    /**
     * @param League $tournament
     *
     * @return array
     */
    protected function handleLeague(League $tournament)
    {
        $year  = $this->params()->fromRoute('year');
        $month = $this->params()->fromRoute('month');

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

        $viewData = array(
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

        $viewModel = new ViewModel($viewData);
        $viewModel->setTemplate('application/tournament/show-league');

        return $viewModel;
    }

    /**
     * @param Tournament $tournament
     *
     * @return array
     */
    protected function handleTournament(Tournament $tournament)
    {
        $viewModel = new ViewModel(array('tournament' => $tournament));
        $viewModel->setTemplate('application/tournament/show-tournament');

        return $viewModel;
    }

}
