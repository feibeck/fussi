<?php

namespace Application\Model\TournamentPlan;

use Application\Model\Entity\PlannedMatch;
use Application\Model\Entity\Round;

/**
 * Class SingleElimination
 *
 * @see http://en.wikipedia.org/wiki/Single-elimination_tournament
 * @see http://www.indiana.edu/~r324/r324singleelimintro.htm
 */
class SingleElimination
{

    protected $teams;

    /**
     * @param $teams
     *
     * @return Round[]
     */
    public function init($teams)
    {
        $this->teams = $teams;
        shuffle($this->teams);

        $teamcount = count($this->teams);

        $rounds = array();

        $roundCount = $this->numberOfRounds($teamcount);

        for ($roundIndex = 0; $roundIndex < $roundCount; $roundIndex++) {

            /** @var Round $previousRound */
            $previousRound = $roundIndex > 0 ? $rounds[$roundIndex - 1] : null;

            if ($roundIndex == 0) {
                $numberOfEntries = $this->numberOfFirstRoundGames($teamcount) * 2;
            } else if ($roundIndex == 1) {
                $numberOfEntries = $previousRound->getMatchCount() + $this->numberOfByes($teamcount);
            } else {
                $numberOfEntries = $previousRound->getMatchCount();
            }

            $rounds[] = $this->createRound($numberOfEntries, $previousRound);

        }

        return $rounds;
    }

    /**
     * @param $numberOfEntries
     *
     * @return int
     */
    protected function numberOfRounds($numberOfEntries)
    {
        return ceil(log($numberOfEntries, 2));
    }

    /**
     * @param $numberOfEntries
     *
     * return int
     */
    protected function numberOfFirstRoundGames($numberOfEntries)
    {
        return $numberOfEntries - pow(2, ceil(log($numberOfEntries, 2)) - 1);
    }

    /**
     * @param $numberOfEntries
     *
     * @return int
     */
    protected function numberOfByes($numberOfEntries)
    {
        return pow(2, ceil(log($numberOfEntries, 2))) - $numberOfEntries;
    }

    /**
     * @param int   $teamCount
     * @param Round $previousRound
     *
     * @return Round
     */
    protected function createRound($teamCount, $previousRound)
    {
        $round = new Round();

        for ($i = 0; $i < ($teamCount / 2); $i++) {

            $match = new PlannedMatch();

            $matchForTeam1 = $previousRound ? $previousRound->getMatch($i * 2) : null;
            $matchForTeam2 = $previousRound ? $previousRound->getMatch($i * 2 + 1) : null;

            if ($matchForTeam1 != null) {
                $matchForTeam1->winnerPlaysInMatchAt($match, 0);
            } else {
                $match->setTeam1(array_pop($this->teams));
            }

            if ($matchForTeam2 != null) {
                $matchForTeam2->winnerPlaysInMatchAt($match, 1);
            } else {
                $match->setTeam2(array_pop($this->teams));
            }

            $round->addMatch($match);

        }
        return $round;
    }

}