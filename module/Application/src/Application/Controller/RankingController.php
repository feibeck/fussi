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

use Application\Model\Entity\DoubleMatch;
use Application\Model\Entity\SingleMatch;
use Application\Model\Ranking\Elo;
use Application\Model\Repository\MatchRepository;
use Application\Model\Repository\PlayerRepository;
use Application\Model\Repository\PointLogRepository;
use Application\Model\Repository\TournamentRepository;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Console\Request as ConsoleRequest;
use Zend\Mvc\Controller\AbstractActionController;

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
     * @var \Application\Model\Repository\PointLogRepository
     */
    protected $pointLogRepository;

    /**
     * @var \Application\Model\Repository\PlayerRepository
     */
    protected $playerRepository;

    /**
     * @var \Zend\Console\Adapter\AdapterInterface
     */
    protected $console;

    protected $ranking = array();

    /**
     * @param \Application\Model\Repository\MatchRepository      $matchRepository
     * @param \Application\Model\Repository\TournamentRepository $tournamentRepository
     * @param \Application\Model\Repository\PointLogRepository   $pointLogRepository
     * @param \Zend\Console\Adapter\AdapterInterface             $console
     */
    public function __construct(
        MatchRepository $matchRepository,
        TournamentRepository $tournamentRepository,
        PointLogRepository $pointLogRepository,
        PlayerRepository $playerRepository,
        Console $console
    )
    {
        $this->matchRepository      = $matchRepository;
        $this->tournamentRepository = $tournamentRepository;
        $this->pointLogRepository   = $pointLogRepository;
        $this->playerRepository     = $playerRepository;
        $this->console              = $console;
    }

    public function eloAction()
    {
        $request = $this->getRequest();

        // Make sure that we are running in a console and the user has not tricked our
        // application into running this action from a public web server.
        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException('You can only use this action from a console!');
        }

        $matches = $this->matchRepository->getAllOrderedByDate();

        $this->pointLogRepository->reset();
        $this->playerRepository->resetRankings();

        foreach ($matches as $match) {

            foreach ($match->getPlayer() as $player) {
                $this->addPlayerToRanking($player);
            }

            $ranking = new Elo();
            $log = $ranking->calculateMatch($match);

            foreach ($match->getPlayer() as $player) {
                $this->playerRepository->persist($player, false);
            }

            $this->pointLogRepository->persist($log, false);
        }

        $this->pointLogRepository->flush();

        $this->console->writeLine(str_repeat("-", $this->console->getWidth() / 2));

        usort($this->ranking, array($this, 'compareRanking'));

        $this->console->writeLine("Rankings:");

        $i = 1;
        foreach ($this->ranking as $player) {
            $this->console->writeLine(
                sprintf(
                    "%d: %d - %s (%d matches)",
                    $i++,
                    $player->getPoints(),
                    $player->getName(),
                    $player->getMatchCount()
                )
            );
        }

    }

    protected function addPlayerToRanking($player)
    {
        if (!in_array($player, $this->ranking)) {
            $this->ranking[] = $player;
        }
    }

    public function compareRanking($player1, $player2)
    {
        return $player2->getPoints() - $player1->getPoints();
    }

}
