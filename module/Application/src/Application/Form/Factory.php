<?php
/**
 * Definition of Application\Form\Factory
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Form;

use Application\Model\Entity\Tournament;
use Application\Model\Entity\PlayerRepository;

class Factory 
{

    /**
     * @var PlayerRepository
     */
    protected $playerRepostitory;

    /**
     * @param \Application\Model\Entity\PlayerRepository $playerRepository
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
