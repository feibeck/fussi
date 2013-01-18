<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use \Doctrine\ORM\EntityManager;

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

}
