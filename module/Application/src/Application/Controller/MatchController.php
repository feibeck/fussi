<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Doctrine\ORM\EntityManager;

class MatchController extends AbstractActionController
{

    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function addAction()
    {
        $tournamentId = $this->params()->fromRoute('tid');

        $tournament = $this->em->getRepository('Application\Entity\Tournament')->find($tournamentId);

        $form = new \Application\Form\DoubleMatch(
            $tournament->getPlayers()
        );

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {

                $match = new \Application\Entity\DoubleMatch();
                $match->setTournament($tournament);

                $now = new \DateTime();
                $now->setTime(0, 0, 0);
                $now->modify('first day of');

                $match->setDate($now);

                /** @var $matchRepository \Application\Entity\PlayerRepository */
                $playerRepository = $this->em->getRepository('Application\Entity\Player');

                $match->setTeamOne(
                    $playerRepository->find($form->get('t1a')->getValue()),
                    $playerRepository->find($form->get('t1d')->getValue())
                );

                $match->setTeamTwo(
                    $playerRepository->find($form->get('t2a')->getValue()),
                    $playerRepository->find($form->get('t2d')->getValue())
                );

                $match->setGoalsGame1Player1($form->get('goalsGame1Team1')->getValue());
                $match->setGoalsGame1Player2($form->get('goalsGame1Team2')->getValue());
                $match->setGoalsGame2Player1($form->get('goalsGame2Team1')->getValue());
                $match->setGoalsGame2Player2($form->get('goalsGame2Team2')->getValue());

                $this->em->persist($match);
                $this->em->flush();

                return $this->redirect()->toRoute(
                    'tournament/show',
                    array('id' => $tournament->getId(), 'year' => $now->format('Y'), 'month', $now->format('m'))
                );
            }
        }

        return array(
            'tournament' => $tournament,
            'form' => $form
        );
    }

}