<?php
/**
 * Definition of Application\Model\Entity\Round
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="round")
 */
class Round
{

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Application\Model\Entity\PlannedMatch", mappedBy="planned-match", cascade={"persist"})
     */
    protected $matches;

    /**
     * @var TournamentTournament
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\TournamentTournament")
     * @ORM\JoinColumn(name="tournament_id", referencedColumnName="id")
     */
    protected $tournament;

    public function __construct()
    {
        $this->matches = new ArrayCollection();
    }

    /**
     * @param PlannedMatch $match
     */
    public function addMatch(PlannedMatch $match)
    {
        $this->matches->add($match);
    }

    /**
     * @param $index
     *
     * @return PlannedMatch
     */
    public function getMatch($index)
    {
        return $this->matches->get($index);
    }

    /**
     * @return PlannedMatch[]
     */
    public function getMatches()
    {
        return $this->matches->toArray();
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Application\Model\Entity\TournamentTournament $tournament
     */
    public function setTournament($tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * @return \Application\Model\Entity\TournamentTournament
     */
    public function getTournament()
    {
        return $this->tournament;
    }

}
