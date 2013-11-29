<?php
/**
 * Definition of Application\Model\EloPlayer
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

use Application\Model\Entity\SingleMatch;

class EloPlayer extends Elo
{

    public function updatePlayers()
    {
        $this->match->getPlayer1()->setPoints($this->newElo1);
        $this->match->getPlayer2()->setPoints($this->newElo2);

        $this->match->getPlayer1()->incrementMatchCount();
        $this->match->getPlayer2()->incrementMatchCount();
    }

    /**
     * @param SingleMatch $match
     *
     * @return int
     */
    protected function getPointsParticipant1($match)
    {
        return $match->getPlayer1()->getPoints();
    }

    /**
     * @param SingleMatch $match
     *
     * @return int
     */
    protected function getPointsParticipant2($match)
    {
        return $match->getPlayer2()->getPoints();
    }

}