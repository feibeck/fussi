<?php
/**
 * Definition of Application\Model\Entity\Team
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

use \Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="team")
 */
class Team
{

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\Player")
     * @ORM\JoinColumn(name="player1_id", referencedColumnName="id")
     */
    protected $player1;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\Player")
     * @ORM\JoinColumn(name="player2_id", referencedColumnName="id")
     */
    protected $player2;

    /**
     * @var Tournament
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\Tournament")
     * @ORM\JoinColumn(name="tournament_id", referencedColumnName="id")
     */
    protected $tournament;

    /**
     * @param Player $player1
     * @param Player $player2
     */
    function __construct(Player $player1 = null, Player $player2 = null)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
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
     * @param \Application\Model\Entity\Player $player1
     */
    public function setPlayer1($player1)
    {
        $this->player1 = $player1;
    }

    /**
     * @return \Application\Model\Entity\Player
     */
    public function getPlayer1()
    {
        return $this->player1;
    }

    /**
     * @param \Application\Model\Entity\Player $player2
     */
    public function setPlayer2($player2)
    {
        $this->player2 = $player2;
    }

    /**
     * @return \Application\Model\Entity\Player
     */
    public function getPlayer2()
    {
        return $this->player2;
    }

    /**
     * @param \Application\Model\Entity\Tournament $tournament
     */
    public function setTournament($tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * @return \Application\Model\Entity\Tournament
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * Returns a string representation as a name of the team
     *
     * @return string
     */
    public function getName()
    {
        return sprintf(
            "%s / %s",
            $this->getPlayer1()->getName(),
            $this->getPlayer2()->getName()
        );
    }

}
