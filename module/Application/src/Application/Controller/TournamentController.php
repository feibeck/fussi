<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use \Doctrine\ORM\EntityManager;

use \Application\Form\Tournament as TournamentForm;
use \Application\Entity\Tournament as Tournament;

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
        return array(
            'tournament' => $tournament
        );
    }

    public function addAction()
    {
        $form = new TournamentForm();

        $tournament = new Tournament();
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
