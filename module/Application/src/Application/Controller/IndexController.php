<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use \Doctrine\ORM\EntityManager;

use \Application\Ranking;
use \Application\Form\Match as MatchForm;
use \Application\Entity\Match as MatchEntity;
use \Datetime;

class IndexController extends AbstractActionController
{

    /**
     * @var EntityManager
     */
    private $em;

    protected $startDate;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function setStartDate(\DateTime $date)
    {
        $this->startDate = $date;
    }

    public function indexAction()
    {
        $year  = $this->params()->fromRoute('year');
        $month = $this->params()->fromRoute('month');
        $id    = $this->params()->fromRoute('id');

        $date = new DateTime();
        $date->setDate($year, $month, 1);

        $date->setTime(0, 0, 0);

        $now = new DateTime();
        $now->setTime(0, 0, 0);
        $now->modify('first day of');

        if ($date > $now || $date < $this->startDate) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $repository = $this->em->getRepository('Application\Entity\Player');
        $players = $repository->findAll();

        $tournamentRepository = $this->em->getRepository('Application\Entity\Tournament');
        $tournament = $tournamentRepository->find($id);

        $matchRepository = $this->em->getRepository('Application\Entity\Match');
        $matches = $matchRepository->findForMonth($tournament, $year, $month);

        $ranking = new Ranking($matches);
        $playersRanking = $ranking->getRanking();

        return array(
            'date'    => $date,
            'players' => $players,
            'matches' => $matches,
            'playersRanking' => $playersRanking,
            'startDate' => $this->startDate,
            'tournament' => $tournament
        );

    }

    public function matchresultAction()
    {
        $id = $this->params()->fromRoute('id');

        $idPlayer1 = $this->params()->fromRoute('player1');
        $idPlayer2 = $this->params()->fromRoute('player2');

        $year  = $this->params()->fromRoute('year');
        $month = $this->params()->fromRoute('month');

        $date = new DateTime();
        $date->setDate($year, $month, 1);

        /** @var $matchRepository \Application\Entity\PlayerRepository */
        $playerRepository = $this->em->getRepository('Application\Entity\Player');
        $player1 = $playerRepository->find($idPlayer1);
        $player2 = $playerRepository->find($idPlayer2);

        $tournamentRepository = $this->em->getRepository('Application\Entity\Tournament');
        $tournament = $tournamentRepository->find($id);

        /** @var $matchRepository \Application\Entity\MatchRepository */
        $matchRepository = $this->em->getRepository('Application\Entity\Match');
        $match = $matchRepository->getMatch($tournament, $year, $month, $player1, $player2);

        if ($match == null) {
            $match = new MatchEntity();
            $match->setTournament($tournament);
            $match->setPlayer1($player1);
            $match->setPlayer2($player2);
            $date = new DateTime();
            $date->setDate($year, $month, 1);
            $match->setDate($date);
        }

        $now = new Datetime();
        if ($now->format('Ym') != $date->format('Ym')) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $form = new MatchForm();
        $form->bind($match);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {

                $this->em->persist($match);
                $this->em->flush();

                return $this->redirect()->toRoute(
                    'tournament',
                    array('id' => $tournament->getId(), 'year' => $year, 'month', $month)
                );
            }
        }

        return array(
            'form' => $form,
            'player1' => $player1,
            'player2' => $player2
        );
    }

}
