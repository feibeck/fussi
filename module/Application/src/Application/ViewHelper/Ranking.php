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

use Application\Model\Repository\MatchRepository;
use Application\Model\Entity\League;
use Application\Model\Ranking as RankingCalculator;
use Zend\View\Helper\AbstractHelper;

class Ranking extends AbstractHelper
{

    /**
     * @var \Application\Model\Repository\MatchRepository
     */
    protected $matchRepository;

    public function __construct(MatchRepository $matchRepository = null)
    {
        $this->matchRepository = $matchRepository;
    }

    /**
     * @param \Application\Model\Entity\League $tournament
     * @param int $potential
     * @param \Application\Model\LeaguePeriod $period
     * @param int $count
     *
     * @return string
     */
    public function __invoke(
        League $tournament,
        $potential,
        $period,
        $count = 0
    )
    {
        $matches = $this->matchRepository->findForPeriod(
            $tournament,
            $period
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
