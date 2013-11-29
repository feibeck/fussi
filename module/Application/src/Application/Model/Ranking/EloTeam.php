<?php
/**
 * Definition of Application\Model\Ranking\EloTeam
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Model\Ranking;

use Application\Model\Entity\DoubleMatch;
use Application\Model\Team;

class EloTeam extends Elo
{

    public function updatePlayers()
    {
        $this->updateTeam($this->match->getTeamOne(), $this->difference1);
        $this->updateTeam($this->match->getTeamTwo(), $this->difference2);
    }

    /**
     * @param DoubleMatch $match
     *
     * @return int
     */
    protected function getPointsParticipant1($match)
    {
        return $this->getPointsForTeam($match->getTeamOne());
    }

    /**
     * @param DoubleMatch $match
     *
     * @return int
     */
    protected function getPointsParticipant2($match)
    {
        return $this->getPointsForTeam($match->getTeamTwo());
    }

    /**
     * @param Team $team
     *
     * @return float
     */
    protected function getPointsForTeam($team)
    {
        $sum = $team->getAttackingPlayer()->getPoints() + $team->getDefendingPlayer()->getPoints();
        return round($sum / 2);
    }

    /**
     * @param $team
     * @param $diff
     */
    protected function updateTeam($team, $diff)
    {
        $this->_updatePlayer($diff, $team->getAttackingPlayer());
        $this->_updatePlayer($diff, $team->getDefendingPlayer());
    }

    /**
     * @param $diff
     * @param $player
     */
    protected function _updatePlayer($diff, $player)
    {
        $player->setPoints($player->getPoints() + $diff);
        $player->incrementMatchCount();
    }

}
