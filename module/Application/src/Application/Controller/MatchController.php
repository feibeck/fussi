<?php

namespace Application\Controller;

use Application\Entity\TournamentRepository;
use Application\Entity\Tournament;
use Application\Entity\Match;
use Application\Entity\MatchRepository;
use Application\Entity\PlayerRepository;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MatchController extends AbstractActionController
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var PlayerRepository
     */
    protected $playerRepository;
    
    /**
     * @var TournamentRepository
     */
    protected $tournamentRepository;

    /**
     * @var MatchRepository
     */
    protected $matchRepository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->tournamentRepository = $em->getRepository('Application\Entity\Tournament');
        $this->playerRepository = $em->getRepository('Application\Entity\Player');
        $this->matchRepository = $em->getRepository('Application\Entity\Match');
    }

    public function newAction()
    {
        $tournamentId = $this->params()->fromRoute('tid');
        $tournament = $this->tournamentRepository->find($tournamentId);

        $player1Id = $this->params()->fromRoute('player1');
        $player2Id = $this->params()->fromRoute('player2');
        $player1 = $player1Id == null ? null : $this->playerRepository->find($player1Id);
        $player2 = $player2Id == null ? null : $this->playerRepository->find($player2Id);

        $match = $this->matchRepository->getNew($tournament, $player1, $player2);
        return $this->handleForm($match);
    }

    public function editAction()
    {
        $matchId = $this->params()->fromRoute('mid');
        $match = $this->matchRepository->find($matchId);
        $tournament = $match->getTournament();
        return $this->handleForm($match, $tournament);
    }

    /**
     * @param Match $match
     *
     * @return ViewModel
     */
    protected function handleForm($match)
    {
        $tournament = $match->getTournament();

        $factory = new \Application\Form\Factory($this->playerRepository);
        $form = $factory->getMatchForm($tournament);

        $form->bind($match);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {

                $this->em->persist($match);
                $this->em->flush();

                return $this->redirect()->toRoute(
                    'tournament/show',
                    array('id' => $tournament->getId())
                );

            }
        }

        if ($match->getId() != null) {
            $url = $this->url()->fromRoute('match/edit/', array('mid' => $match->getId()));
            $form->setAttribute('action', $url);
        }

        $view = new ViewModel(
            array(
                'form' => $form,
            )
        );
        $view->setTemplate('application/match/edit');

        if ($this->getRequest()->isXmlHttpRequest()) {
            $view->setTerminal(true);
        }

        return $view;
    }

}