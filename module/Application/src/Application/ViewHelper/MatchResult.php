<?php
/**
 * Definition of Application\ViewHelper\Match
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

use Zend\View\Helper\AbstractHelper;

/**
 * Format output of match results
 */
class MatchResult extends AbstractHelper
{

    /**
     * @param \Application\Model\Entity\Match $match
     *
     * @return string
     */
    public function __invoke($match)
    {
        $gameResults = array();
        $games = $match->getGames();
        foreach ($games as $game) {
            $goalsOne = $game->getGoalsTeamOne();
            $goalsTwo = $game->getGoalsTeamTwo();
            $gameResults[] = $goalsOne . ":" . $goalsTwo;
        }

        return implode(", ", $gameResults);
    }

}
