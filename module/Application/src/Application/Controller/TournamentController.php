<?php
/**
 * Definition of Application\Controller\IndexController
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
use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;

/**
 * Controller displaying the monthly view of a league tournament
 */
class TournamentController extends AbstractActionController
{

    /**
     * @var TournamentRepository
     */
    protected $repository;

    /**
     * @param TournamentRepository $repository
     */
    public function __construct(TournamentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     *
     * @throws \RuntimeException
     */
    public function showAction()
    {
        $id = $this->params()->fromRoute('id');

        $tournament = $this->repository->find($id);
        if (!$tournament instanceof \Application\Model\Entity\Tournament) {
            throw new \RuntimeException('Invalid tournament ID');
        }

        return array('tournament' => $tournament);
    }

}
