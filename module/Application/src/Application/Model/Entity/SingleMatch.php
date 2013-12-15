<?php
/**
 * Definition of Application\Model\Entity\SingleMatch
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

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SingleMatch extends Match
{

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
     * @param Player $player1
     */
    public function setPlayer1($player1)
    {
        $this->player1 = $player1;
    }

    /**
     * @return Player
     */
    public function getPlayer1()
    {
        return $this->player1;
    }

    /**
     * @param Player $player2
     */
    public function setPlayer2($player2)
    {
        $this->player2 = $player2;
    }

    /**
     * @return Player
     */
    public function getPlayer2()
    {
        return $this->player2;
    }

    /**
     * Checks wether the match is played by two specific players
     *
     * @param Player $player1
     * @param Player $player2
     *
     * @return bool
     */
    public function isPlayedBy($player1, $player2)
    {

        return ($this->player1 === $player1 && $this->player2 === $player2)
            || ($this->player2 === $player1 && $this->player1 === $player2);

    }

    /**
     * @param Player $player
     *
     * @return int
     *
     * @throws \RuntimeException
     */
    public function getSideForPlayer(Player $player)
    {
        if ($player == $this->player1) {
            return 1;
        } else if ($player == $this->player2) {
            return 2;
        }
        throw new \RuntimeException('Player did not play in this match');
    }

}