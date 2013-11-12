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

use Application\Model\Entity\AbstractTournament;
use Application\Model\Entity\PlannedMatch;
use Application\Model\Repository\PlayerRepository;

class Factory
{

    /**
     * @var PlayerRepository
     */
    protected $playerRepostitory;

    /**
     * @param PlayerRepository $playerRepository
     */
    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * @param AbstractTournament $tournament
     * @param PlannedMatch       $plannedMatch
     *
     * @return MatchForm
     */
    public function getMatchForm(AbstractTournament $tournament, PlannedMatch $plannedMatch = null)
    {
        if ($tournament->getTeamType() == $tournament::TYPE_SINGLE) {

            $form = new MatchFormSingle(
                $this->playerRepository,
                $tournament->getGamesPerMatch(),
                $tournament->getMaxScore()
            );

        } else {

            if ($plannedMatch == null) {

                $form = new MatchFormDouble(
                    $this->playerRepository,
                    $tournament->getGamesPerMatch(),
                    $tournament->getMaxScore(),
                    $tournament->getPlayers()
                );

            } else {

                $form = new MatchFormDouble(
                    $this->playerRepository,
                    $tournament->getGamesPerMatch(),
                    $tournament->getMaxScore(),
                    array()
                );

                $form->setTeamOne($plannedMatch->getTeam1());
                $form->setTeamTwo($plannedMatch->getTeam2());

            }

        }

        return $form;
    }

}
