<?php

namespace Application\Form;

use \Application\Entity\Tournament;
use \Application\Entity\PlayerRepository;

class Factory 
{

    protected $playerRepostitory;

    /**
     * @param PlayerRepository $playerRepository
     */
    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * @param Tournament $tournament
     *
     * @return MatchForm
     */
    public function getMatchForm(Tournament $tournament)
    {
        if ($tournament->getTeamType() == $tournament::TYPE_SINGLE) {

            $form = new MatchFormSingle(
                $this->playerRepository,
                $tournament->getGamesPerMatch()
            );

        } else {

            $form = new MatchFormDouble(
                $this->playerRepository,
                $tournament->getGamesPerMatch(),
                $tournament->getPlayers()
            );

        }

        return $form;
    }

}
