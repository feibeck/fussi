<?php
/**
 * Definition of Application\Controller\MatchController
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

use Application\Model\Repository\TournamentRepository;
use Application\Model\Entity\League;
use Application\Model\Entity\Match;
use Application\Model\Entity\PlannedMatch;
use Application\Model\Repository\MatchRepository;
use Application\Model\Repository\PlayerRepository;
use Application\Model\Repository\PlannedMatchRepository;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Controller for adding and editing matches
 */
class MatchController extends AbstractActionController
{

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

    /**
     * @var PlannedMatchRepository
     */
    protected $plannedMatchRepository;

    /**
     * @param MatchRepository        $matchRepository
     * @param TournamentRepository   $tournamentRepository
     * @param PlayerRepository       $playerRepository
     * @param PlannedMatchRepository $plannedMatchRepository
     */
    public function __construct(
        MatchRepository        $matchRepository,
        TournamentRepository   $tournamentRepository,
        PlayerRepository       $playerRepository,
        PlannedMatchRepository $plannedMatchRepository
    )
    {
        $this->matchRepository        = $matchRepository;
        $this->tournamentRepository   = $tournamentRepository;
        $this->playerRepository       = $playerRepository;
        $this->plannedMatchRepository = $plannedMatchRepository;
    }

    /**
     * @return ViewModel
     */
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

    /**
     * @return ViewModel
     */
    public function editAction()
    {
        $matchId = $this->params()->fromRoute('mid');
        $match = $this->matchRepository->find($matchId);
        $tournament = $match->getTournament();
        return $this->handleForm($match, $tournament);
    }

    /**
     * @return ViewModel
     */
    public function plannedAction()
    {
        $plannedMatchId = $this->params()->fromRoute('pid');
        $plannedMatch = $this->plannedMatchRepository->find($plannedMatchId);
        $tournament = $plannedMatch->getTournament();

        $match = $this->matchRepository->getNew($tournament);
        return $this->handleForm($match, $plannedMatch);
    }

    /**
     * @param Match        $match
     * @param PlannedMatch $plannedMatch
     *
     * @return ViewModel
     */
    protected function handleForm($match, $plannedMatch = null)
    {
        $tournament = $match->getTournament();

        $factory = new \Application\Form\Factory($this->playerRepository);
        $form = $factory->getMatchForm($tournament, $plannedMatch);

        $form->bind($match);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {

                $this->matchRepository->persist($match);

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
                'form'       => $form,
                'tournament' => $tournament
            )
        );
        $view->setTemplate('application/match/edit');

        if ($this->getRequest()->isXmlHttpRequest()) {
            $view->setTerminal(true);
        }

        return $view;
    }

}