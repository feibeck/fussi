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

        $date = new DateTime();
        $date->setDate($year, $month, 1);

        $date->setTime(0, 0, 0);

        $now = new DateTime();
        $now->setTime(0, 0, 0);
        $now->modify('first day of');

        if ($date > $now || $date < $tournament->getStart()->modify('first day of')) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $matches = $this->matchRepository->findForMonth($tournament, $year, $month);

        $players = $tournament->getPlayers();
        $activePlayers = $this->matchRepository->getActivePlayers($tournament, $year, $month);

        if ($now->format('Ym') != $date->format('Ym')) {
            $players = $activePlayers;
        }

        $ranking = new Ranking($matches);

        return array(
            'date'           => $date,
            'players'        => $players,
            'activePlayers'  => $activePlayers,
            'matches'        => $matches,
            'ranking'        => $ranking,
            'startDate'      => $tournament->getStart()->modify('first day of'),
            'tournament'     => $tournament,
        );

    }

}
