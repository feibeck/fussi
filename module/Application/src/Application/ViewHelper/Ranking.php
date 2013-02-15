<?php

namespace Application\ViewHelper;

use Application\Entity\MatchRepository;
use Application\Ranking as RankingCalculator;
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

    public function __invoke($tournament, $potential, $year, $month, $count = 0)
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
