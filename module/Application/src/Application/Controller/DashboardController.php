<?php

namespace Application\Controller;

use Application\Entity\MatchRepository;
use Application\Entity\TournamentRepository;
use Zend\Mvc\Controller\AbstractActionController;

class DashboardController extends AbstractActionController
{

    /**
     * @var MatchRepository
     */
    protected $matchRepository;

    /**
     * @var TournamentRepository
     */
    protected $tournamentRepository;

    public function __construct(
        MatchRepository $matchRepository,
        TournamentRepository $tournamentRepository
    )
    {
        $this->matchRepository = $matchRepository;
        $this->tournamentRepository = $tournamentRepository;
    }

    public function dashboardAction()
    {
        return array(
            'matches' => $this->matchRepository->getLastMatches(),
            'tournaments' => $this->tournamentRepository->findAll()
        );
    }

}
