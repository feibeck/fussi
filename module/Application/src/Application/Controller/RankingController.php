<?php
/**
 * Definition of Application\Controller\DashboardController
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

use Application\Model\Elo;
use Application\Model\Repository\MatchRepository;
use Application\Model\Repository\TournamentRepository;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;
use Zend\Console\Adapter\AdapterInterface as Console;

class RankingController extends AbstractActionController
{

    /**
     * @var \Application\Model\Repository\MatchRepository
     */
    protected $matchRepository;

    /**
     * @var \Application\Model\Repository\TournamentRepository
     */
    protected $tournamentRepository;

    /**
     * @var \Zend\Console\Adapter\AdapterInterface
     */
    protected $console;

    /**
     * @param \Application\Model\Repository\MatchRepository      $matchRepository
     * @param \Application\Model\Repository\TournamentRepository $tournamentRepository
     * @param \Zend\Console\Adapter\AdapterInterface             $console
     */
    public function __construct(
        MatchRepository $matchRepository,
        TournamentRepository $tournamentRepository,
        Console $console
    )
    {
        $this->matchRepository = $matchRepository;
        $this->tournamentRepository = $tournamentRepository;
        $this->console = $console;
    }

    public function eloAction()
    {
        $request = $this->getRequest();

        // Make sure that we are running in a console and the user has not tricked our
        // application into running this action from a public web server.
        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException('You can only use this action from a console!');
        }

        /** @var \Application\Model\Entity\League $tournament */
        $tournament = $this->tournamentRepository->find(1);

        $eloRankings = array();

        $matches = $this->matchRepository->findForTournament($tournament);

        /** @var \Application\Model\Entity\SingleMatch $match */
        foreach ($matches as $match) {

            if (!in_array($match->getPlayer1(), $eloRankings)) {
                $eloRankings[] = $match->getPlayer1();
            }
            if (!in_array($match->getPlayer2(), $eloRankings)) {
                $eloRankings[] = $match->getPlayer2();
            }

            $oldRanking1 = $match->getPlayer1()->getPoints();
            $oldRanking2 = $match->getPlayer2()->getPoints();

            $ranking = new Elo($match);
            $ranking->updatePlayers();

            $this->console->writeLine(
                sprintf(
                    '%s vs. %s - Chances %s%%/%s%%. Points %d (%+d) / %d (%+d)',
                    $match->getPlayer1()->getName(),
                    $match->getPlayer2()->getName(),
                    $ranking->getChance1(),
                    $ranking->getChance2(),
                    $match->getPlayer1()->getPoints(),
                    $match->getPlayer1()->getPoints() - $oldRanking1,
                    $match->getPlayer2()->getPoints(),
                    $match->getPlayer2()->getPoints() - $oldRanking2
                )
            );

        }

        $this->console->writeLine(str_repeat("-", $this->console->getWidth() / 2));

        usort($eloRankings, array($this, 'compareRanking'));

        $this->console->writeLine("Rankings:");

        $i = 1;
        foreach ($eloRankings as $player) {
            $this->console->writeLine(
                sprintf(
                    "%d: %d - %s",
                    $i++,
                    $player->getPoints(),
                    $player->getName()
                )
            );
        }

    }

    public function compareRanking($player1, $player2)
    {
        return $player2->getPoints() - $player1->getPoints();
    }

}
