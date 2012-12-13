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

        $date = new DateTime();
        $date->setDate($year, $month, 1);

        $repository = $this->em->getRepository('Application\Entity\Player');
        $players = $repository->findAll();

        $matchRepository = $this->em->getRepository('Application\Entity\Match');
        $matches = $matchRepository->findForMonth($year, $month);

        $ranking = new Ranking($matches);
        $playersRanking = $ranking->getRanking();

        return array(
            'date'    => $date,
            'players' => $players,
            'matches' => $matches,
            'playersRanking' => $playersRanking
        );

    }

    public function matchresultAction()
    {
        $idPlayer1 = $this->params()->fromRoute('player1');
        $idPlayer2 = $this->params()->fromRoute('player2');

        $year  = $this->params()->fromRoute('year');
        $month = $this->params()->fromRoute('month');

        $playerRepository = $this->em->getRepository('Application\Entity\Player');
        $player1 = $playerRepository->find($idPlayer1);
        $player2 = $playerRepository->find($idPlayer2);

        $form = new MatchForm();

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {

                $match = new MatchEntity();
                $match->setPlayer1($player1);
                $match->setPlayer2($player2);

                $data = $form->getData();

                $match->setGoalsGame1Player1($data['p1g1']);
                $match->setGoalsGame1Player2($data['p2g1']);
                $match->setGoalsGame2Player1($data['p1g2']);
                $match->setGoalsGame2Player2($data['p2g2']);

                $date = new DateTime();
                $date->setDate($year, $month, 1);
                $match->setDate($date);

                $this->em->persist($match);
                $this->em->flush();

                return $this->redirect()->toRoute(
                    'home',
                    array('year' => $year, 'month', $month)
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
