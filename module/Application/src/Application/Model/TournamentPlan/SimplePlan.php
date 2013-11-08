<?php

namespace Application\Model\TournamentPlan;

use Application\Model\Entity\Round;

class SimplePlan
{

    protected $teams;

    public function __construct($teams)
    {
        $this->teams = $teams;
    }

    public function getRounds()
    {
        return $this->rounds;
    }

    public function init()
    {
        $teamcount = count($this->teams);
        if ($teamcount % 4 != 0) {
            throw new \RuntimeException(
                'Anzahl der Teams muss durch 4 teilbar sein'
            );
        }
        $rounds = array();
        $roundcount = log($teamcount, 2);

        $rounds[] = $this->createFirstRound($teamcount);

        for ($roundIndex = 1; $roundIndex < $roundcount; $roundIndex++) {
            $rounds[] = $this->createRound($roundIndex, $rounds[$roundIndex - 1]);
        }

        return $rounds;
    }

    /**
     * @return Round
     */
    protected function createFirstRound()
    {
        $teamcount = count($this->teams);
        $round = new Round();
        for ($i = 0; $i < $teamcount; $i += 2) {
            $match = new \Application\Model\Entity\PlannedMatch(
                $this->teams[$i],
                $this->teams[$i + 1]
            );
            $round->addMatch($match);
        }
        return $round;
    }

    /**
     * @param int   $roundIndex
     * @param Round $previousRound
     *
     * @return Round
     */
    protected function createRound($roundIndex, Round $previousRound)
    {
        $teamcount = count($this->teams);
        $round = new Round();

        $numberOfMatches = $teamcount / pow(2, $roundIndex + 1);

        for ($i = 0; $i < $numberOfMatches; $i++) {

            $match = new \Application\Model\Entity\PlannedMatch();

            $matchForTeam1 = $previousRound->getMatch($i * 2);
            $matchForTeam2 = $previousRound->getMatch($i * 2 + 1);

            $match->teamOneIsWinnerFrom($matchForTeam1);
            $match->teamTwoIsWinnerFrom($matchForTeam2);

            $matchForTeam1->winnerPlaysInMatchAt($match, 0);
            $matchForTeam2->winnerPlaysInMatchAt($match, 1);

            $round->addMatch($match);
        }
        return $round;
    }

}