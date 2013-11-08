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

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;

/**
 * Controller displaying the monthly view of a league tournament
 */
class PlayTournamentController extends AbstractActionController
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
        $repository = $this->em->getRepository('\Application\Model\Entity\TournamentTournament');
        $tournaments = $repository->findAll();
        return $tournaments;
    }

    public function addAction()
    {

    }

    /**
     * @return array
     */
    public function indexAction()
    {
        $player = array();
        $tournament = new \Application\Model\Entity\TournamentTournament();
        for ($i = 1; $i <= 16; $i++) {
            $player[] = $this->getPlayer($i, 'Foo' . $i);
        }

        $teamGenerator = new \Application\Model\TeamGenerator();
        $teams = $teamGenerator->generateTeams($player);

        $plan = new \Application\Model\TournamentPlan\SimplePlan($teams);
        $rounds = $plan->init();

        $tournament->init($teams, $rounds);
        return array('tournament' => $tournament);
    }

    protected function getPlayer($id, $name)
    {
        $player = new \Application\Model\Entity\Player();
        $player->setId($id);
        $player->setName($name);
        return $player;
    }

}
