<?php
/**
 * Definition of Application\ViewHelper\Ranking
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\ViewHelper;

use Application\Entity\MatchRepository;
use Application\Entity\Tournament;
use Application\Model\Ranking as RankingCalculator;
use Zend\View\Helper\AbstractHelper;

class Ranking extends AbstractHelper
{

    /**
     * @var MatchRepository
     */
    protected $matchRepository;

    public function __construct(MatchRepository $matchRepository = null)
    {
        $this->matchRepository = $matchRepository;
    }

    /**
     * @param Tournament $tournament
     * @param int $potential
     * @param int $year
     * @param int $month
     * @param int $count
     *
     * @return string
     */
    public function __invoke(
        Tournament $tournament,
        $potential,
        $year,
        $month,
        $count = 0
    )
    {
        $matches = $this->matchRepository->findForMonth(
            $tournament,
            $year,
            $month
        );

        $ranking = new RankingCalculator($matches);

        $model = new \Zend\View\Model\ViewModel(
            array(
                'ranking' => $ranking,
                'count'   => $count,
                'tournamentPotential' => $potential,
            )
        );
        $model->setTemplate('ranking-table.phtml');

        return $this->getView()->render($model);

    }

}
