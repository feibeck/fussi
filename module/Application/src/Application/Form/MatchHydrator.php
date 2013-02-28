<?php
/**
 * Definition of Application\Form\MatchHydrator
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

use \Application\Entity\DoubleMatch;
use \Application\Entity\SingleMatch;
use \Application\Entity\Match;
use \Application\Entity\PlayerRepository;
use \Zend\Stdlib\Hydrator\HydratorInterface;

class MatchHydrator implements HydratorInterface
{

    /**
     * @var PlayerRepository
     */
    protected $repository;

    public function __construct(PlayerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Extract values from an object
     *
     * @param Match $match
     *
     * @return array
     */
    public function extract($match)
    {
        if ($match instanceof DoubleMatch) {

            $teamOne = $match->getTeamOne();
            $teamTwo = $match->getTeamTwo();

            return array(
                'games'          => $match->getGames(),
                'teamOneAttack'  => ($teamOne ? $teamOne->getAttackingPlayer()->getId() : null),
                'teamOneDefence' => ($teamOne ? $teamOne->getDefendingPlayer()->getId() : null),
                'teamTwoAttack'  => ($teamTwo ? $teamTwo->getAttackingPlayer()->getId() : null),
                'teamTwoDefence' => ($teamTwo ? $teamTwo->getDefendingPlayer()->getId() : null),
            );

        } else if ($match instanceof SingleMatch) {

            return array(
                'games' => $match->getGames()
            );

        }
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param array $data
     * @param Match $match
     *
     * @return Match
     */
    public function hydrate(array $data, $match)
    {
        $match->setGames($data['games']);

        if ($match instanceof DoubleMatch) {
            $match->setTeamOne(
                $this->repository->find($data['teamOneAttack']),
                $this->repository->find($data['teamOneDefence'])
            );
            $match->setTeamTwo(
                $this->repository->find($data['teamTwoAttack']),
                $this->repository->find($data['teamTwoDefence'])
            );
        }

        return $match;
    }

}
