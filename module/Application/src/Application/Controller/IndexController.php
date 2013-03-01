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

use \Application\Ranking;
use \Application\Entity\TournamentRepository;
use \Application\Entity\Tournament;

use \Datetime;

use \Doctrine\ORM\EntityManager;

/**
 * Controller displaying the monthly view of a league tournament
 */
class IndexController extends AbstractActionController
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function indexAction()
    {
        $year  = $this->params()->fromRoute('year');
        $month = $this->params()->fromRoute('month');
        $id    = $this->params()->fromRoute('id');

        /** @var $tournamentRepository TournamentRepository */
        $tournamentRepository = $this->em->getRepository('Application\Entity\Tournament');
        /** @var $tournament Tournament */
        $tournament = $tournamentRepository->find($id);

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

        /** @var $matchRepository \Application\Entity\MatchRepository */
        $matchRepository = $this->em->getRepository('Application\Entity\Match');
        $matches = $matchRepository->findForMonth($tournament, $year, $month);

        $players = $tournament->getPlayers();
        $activePlayers = $matchRepository->getActivePlayers($tournament, $year, $month);

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
