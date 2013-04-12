<?php
/**
 * Definition of Application\Controller\TournamentController
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

use Application\Form\Tournament as TournamentForm;
use Application\Form\PlayerToTournament as AddPlayerForm;
use Application\Model\Entity\Tournament as Tournament;
use Application\Model\Repository\TournamentRepository;
use Application\Model\Repository\PlayerRepository;

/**
 * Managing tournaments
 */
class TournamentController extends AbstractActionController
{

    /**
     * @var TournamentRepository
     */
    protected $tournamentRepository;

    /**
     * @var PlayerRepository
     */
    protected $playerRepository;

    /**
     * @param TournamentRepository $tournamentRepository
     * @param PlayerRepository     $playerRepository
     */
    public function __construct(
        TournamentRepository $tournamentRepository,
        PlayerRepository     $playerRepository
    )
    {
        $this->tournamentRepository = $tournamentRepository;
        $this->playerRepository     = $playerRepository;
    }

    /**
     * @return array
     */
    public function listAction()
    {
        $tournaments = $this->tournamentRepository->findAllActive();
        return array(
            'tournaments' => $tournaments
        );
    }

    /**
     * @return array
     */
    public function playersAction()
    {
        $id = $this->params()->fromRoute('id');
        $tournament = $this->tournamentRepository->find($id);

        $addForm = $this->getAddPlayerForm($tournament);
        $action = $this->url()->fromRoute('tournament/addplayer', array('id' => $id));
        $addForm->setAttribute('action', $action);

        return array(
            'tournament'    => $tournament,
            'addPlayerForm' => $addForm
        );
    }

    /**
     * @return \Zend\Http\Response
     *
     * @throws \Exception
     */
    public function addPlayerAction()
    {
        $id = $this->params()->fromRoute('id');

        $tournament = $this->tournamentRepository->find($id);

        $form = $this->getAddPlayerForm($tournament);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {

                $playerId = $form->get('player')->getValue();
                $player = $this->playerRepository->find($playerId);

                $tournament->addPlayer($player);
                $this->tournamentRepository->persist($tournament);

                return $this->redirect()->toRoute(
                    'tournament/players',
                    array(
                         'id' => $tournament->getId()
                    )
                );
            }
        }

        throw new \Exception();

    }

    /**
     * @param $tournament
     *
     * @return \Application\Form\PlayerToTournament
     */
    protected function getAddPlayerForm($tournament)
    {
        $players = $this->playerRepository->getPlayersNotInTournament(
            $tournament
        );
        $addForm = new AddPlayerForm($players);
        return $addForm;
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function addAction()
    {
        $form = new TournamentForm();

        $tournament = new Tournament();
        $tournament->setStart(new \DateTime());

        $form->bind($tournament);

        $form->setInputFilter(
            new \Application\Form\InputFilter\Tournament(
                $this->tournamentRepository
            )
        );

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->tournamentRepository->persist($tournament);
                return $this->redirect()->toRoute('tournaments');
            }
        }

        return array(
            'form' => $form
        );
    }

}
