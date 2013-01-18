<?php

namespace Application\Controller;

use \Zend\Mvc\Controller\AbstractActionController;

use \Doctrine\ORM\EntityManager;

use \Application\Form\Player as PlayerForm;
use \Application\Entity\Player as Player;

class PlayerController extends AbstractActionController
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

    public function listAction()
    {
	$playerRepository = $this->em->getRepository('Application\Entity\Player');
	$players = $playerRepository->findAll();
	return array(
	    'players' => $players
	);
    }

    public function addAction()
    {
	$form = new PlayerForm();

	$player = new Player();
	$form->bind($player);

	$form->setInputFilter(
	    new \Application\Entity\InputFilter\Player(
		$this->em->getRepository('\Application\Entity\Player')
	    )
	);

	if ($this->request->isPost()) {
	    $form->setData($this->request->getPost());
	    if ($form->isValid()) {
		$this->em->persist($player);
		$this->em->flush();
		return $this->redirect()->toRoute('players');
	    }
	}

	return array(
	    'form' => $form
	);
    }

}
