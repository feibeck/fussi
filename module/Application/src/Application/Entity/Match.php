<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Application\Entity\MatchRepository")
 * @ORM\Table(name="match")
 */
class Match
{

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime",nullable=false)
     */
    private $date;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Player")
     * @ORM\JoinColumn(name="player1_id", referencedColumnName="id")
     */
    private $player1;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Player")
     * @ORM\JoinColumn(name="player2_id", referencedColumnName="id")
     */
    private $player2;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $goalsGame1Player1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $goalsGame1Player2;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $goalsGame2Player1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $goalsGame2Player2;

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param int $goalsGame1Player1
     */
    public function setGoalsGame1Player1($goalsGame1Player1)
    {
        $this->goalsGame1Player1 = $goalsGame1Player1;
    }

    /**
     * @return int
     */
    public function getGoalsGame1Player1()
    {
        return $this->goalsGame1Player1;
    }

    /**
     * @param int $goalsGame1Player2
     */
    public function setGoalsGame1Player2($goalsGame1Player2)
    {
        $this->goalsGame1Player2 = $goalsGame1Player2;
    }

    /**
     * @return int
     */
    public function getGoalsGame1Player2()
    {
        return $this->goalsGame1Player2;
    }

    /**
     * @param int $goalsGame2Player1
     */
    public function setGoalsGame2Player1($goalsGame2Player1)
    {
        $this->goalsGame2Player1 = $goalsGame2Player1;
    }

    /**
     * @return int
     */
    public function getGoalsGame2Player1()
    {
        return $this->goalsGame2Player1;
    }

    /**
     * @param int $goalsGame2Player2
     */
    public function setGoalsGame2Player2($goalsGame2Player2)
    {
        $this->goalsGame2Player2 = $goalsGame2Player2;
    }

    /**
     * @return int
     */
    public function getGoalsGame2Player2()
    {
        return $this->goalsGame2Player2;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

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

    public function getScore()
    {
        $win1 = 0;
        $win2 = 0;

        if ($this->goalsGame1Player1 > $this->goalsGame1Player2) {
            $win1++;
        } else {
            $win2++;
        }

        if ($this->goalsGame2Player1 > $this->goalsGame2Player2) {
            $win1++;
        } else {
            $win2++;
        }

        return $win1 . " / " . $win2;

    }

    public function isPlayedBy($player1, $player2)
    {

        return ($this->player1 == $player1 && $this->player2 == $player2)
            || ($this->player2 == $player1 && $this->player1 == $player2);

    }

}
