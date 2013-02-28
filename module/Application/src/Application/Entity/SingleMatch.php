<?php
/**
 * Definition of Application\Entity\SingleMatch
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SingleMatch extends Match
{

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Player")
     * @ORM\JoinColumn(name="player1_id", referencedColumnName="id")
     */
    protected $player1;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Player")
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

        return ($this->player1 == $player1 && $this->player2 == $player2)
            || ($this->player2 == $player1 && $this->player1 == $player2);

    }

    /**
     * Hydrate the entity by array
     *
     * @param array $data
     */
    public function exchangeArray($data)
    {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }
        if (isset($data['player1'])) {
            $this->player1 = $data['player1'];
        }
        if (isset($data['player2'])) {
            $this->player2 = $data['player2'];
        }
        if (isset($data['goalsGame1Player1'])) {
            $this->setGoalsGame1Player1($data['goalsGame1Player1']);
        }
        if (isset($data['goalsGame1Player2'])) {
            $this->setGoalsGame1Player2($data['goalsGame1Player2']);
        }
        if (isset($data['goalsGame2Player1'])) {
            $this->setGoalsGame2Player1($data['goalsGame2Player1']);
        }
        if (isset($data['goalsGame2Player2'])) {
            $this->setGoalsGame2Player2($data['goalsGame2Player2']);
        }
        if (isset($data['date'])) {
            $this->date = $data['date'];
        }
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return array(
            'id'                => $this->id,
            'player1'           => $this->player1,
            'player2'           => $this->player2,
            'goalsGame1Player1' => $this->getGoalsGame1Player1(),
            'goalsGame1Player2' => $this->getGoalsGame1Player2(),
            'goalsGame2Player1' => $this->getGoalsGame2Player1(),
            'goalsGame2Player2' => $this->getGoalsGame2Player2(),
            'date'              => $this->date
        );
    }

}