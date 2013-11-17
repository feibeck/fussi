<?php
/**
 * Definition of Application\Model\TeamGenerator
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Model;

use Application\Model\Entity\Team;

class TeamGenerator
{

    protected $players;

    public function generateTeams($players)
    {
        $this->players = $players;
        if (count($this->players) % 2 != 0) {
            throw new \RuntimeException('This playing mode needs an equal number of players');
        }

        $availablePlayers = array_keys($this->players);

        $teams = array();

        while (count($availablePlayers) > 0) {
            $team = new Team(
                $this->getRandomPlayer($availablePlayers),
                $this->getRandomPlayer($availablePlayers)
            );
            $teams[] = $team;
        }

        return $teams;
    }

    protected function getRandomPlayer(&$availablePlayers)
    {
        $index = array_rand($availablePlayers);
        $playerIndex = $availablePlayers[$index];
        unset($availablePlayers[$index]);
        return $this->players[$playerIndex];
    }

}