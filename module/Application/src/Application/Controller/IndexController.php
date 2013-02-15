<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use \Application\Ranking;
use \Application\Entity\TournamentRepository;
use \Application\Entity\Tournament;

use \Datetime;

use \Doctrine\ORM\EntityManager;

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

        $players = $tournament->getPlayers();

        $matchRepository = $this->em->getRepository('Application\Entity\Match');
        $matches = $matchRepository->findForMonth($tournament, $year, $month);

        $activePlayers = $matchRepository->getActivePlayers($tournament, $year, $month);

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
