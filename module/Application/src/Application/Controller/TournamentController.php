<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use \Doctrine\ORM\EntityManager;

use \Application\Form\Tournament as TournamentForm;
use \Application\Entity\Tournament as Tournament;

use \Application\Form\PlayerToTournament as AddPlayerForm;

class TournamentController extends AbstractActionController
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function listAction()
    {
        $repository = $this->em->getRepository('Application\Entity\Tournament');
        $tournaments = $repository->findAll();
        return array(
            'tournaments' => $tournaments
        );
    }

    public function playersAction()
    {
        $id = $this->params()->fromRoute('id');
        $repository = $this->em->getRepository('Application\Entity\Tournament');
        $tournament = $repository->find($id);

	$addForm = $this->getAddPlayerForm($tournament);
	$action = $this->url()->fromRoute('tournament/addplayer', array('id' => $id));
	$addForm->setAttribute('action', $action);

        return array(
	    'tournament' => $tournament,
	    'addPlayerForm' => $addForm
        );
    }

    public function addPlayerAction()
    {
	$id = $this->params()->fromRoute('id');

	$tournamentRepository = $this->em->getRepository('Application\Entity\Tournament');
	$tournament = $tournamentRepository->find($id);

	$playerRepository = $this->em->getRepository('Application\Entity\Player');

	$form = $this->getAddPlayerForm($tournament);

	if ($this->request->isPost()) {
	    $form->setData($this->request->getPost());
	    if ($form->isValid()) {

		$playerId = $form->get('player')->getValue();
		$player = $playerRepository->find($playerId);

		$tournament->addPlayer($player);

		$this->em->persist($tournament);
		$this->em->flush();

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

    protected function getAddPlayerForm($tournament)
    {
	$playerRepository = $this->em->getRepository('Application\Entity\Player');
	$players = $playerRepository->getPlayersNotInTournament($tournament);

	$addForm = new AddPlayerForm($players);
	return $addForm;
    }

    public function addAction()
    {
        $form = new TournamentForm();

        $tournament = new Tournament();
        $tournament->setStart(new \DateTime());

        $form->bind($tournament);

        $form->setInputFilter(
            new \Application\Entity\InputFilter\Tournament()
        );

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->em->persist($tournament);
                $this->em->flush();
                return $this->redirect()->toRoute('tournaments');
            }
        }

        return array(
            'form' => $form
        );
    }

}
