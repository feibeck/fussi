<?php

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
     * @param \Application\Entity\Player $player1
     */
    public function setPlayer1($player1)
    {
        $this->player1 = $player1;
    }

    /**
     * @return \Application\Entity\Player
     */
    public function getPlayer1()
    {
        return $this->player1;
    }

    /**
     * @param \Application\Entity\Player $player2
     */
    public function setPlayer2($player2)
    {
        $this->player2 = $player2;
    }

    /**
     * @return \Application\Entity\Player
     */
    public function getPlayer2()
    {
        return $this->player2;
    }

    public function isPlayedBy($player1, $player2)
    {

        return ($this->player1 == $player1 && $this->player2 == $player2)
            || ($this->player2 == $player1 && $this->player1 == $player2);

    }

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
