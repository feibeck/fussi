<?php

namespace Application\Model;

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
            $team = new \Application\Model\Entity\Team(
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