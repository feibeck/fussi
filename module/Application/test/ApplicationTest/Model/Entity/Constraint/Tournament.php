<?php
/**
 * Definition of ApplicationTest\Entity\Constraint\Tournament
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace ApplicationTest\Model\Entity\Constraint;

class Tournament extends \PHPUnit_Framework_Constraint
{

    protected $id;

    protected $name;

    protected $gamesPerMatch;

    protected $start;

    protected $teamType;

    public function __construct($id, $name, $gamesPerMatch, $start, $teamType)
    {
        $this->id            = $id;
        $this->name          = $name;
        $this->gamesPerMatch = $gamesPerMatch;
        $this->start         = $start;
        $this->teamType      = $teamType;
    }

    public function matches($tournament)
    {
        return (
            $tournament->getId() == $this->id &&
            $tournament->getName() == $this->name &&
            $tournament->getGamesPerMatch() == $this->gamesPerMatch &&
            $tournament->getTeamType() == $this->teamType &&
            $tournament->getStart() == $this->start
        );
    }

    public function toString()
    {
        return 'has correct property values';
    }

}