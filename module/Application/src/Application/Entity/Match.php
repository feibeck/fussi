<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Application\Entity\MatchRepository")
 * @ORM\Table(name="match")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"single" = "Application\Entity\SingleMatch", "double" = "Application\Entity\DoubleMatch"})
 */
abstract class Match
{

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Tournament
     *
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Tournament")
     * @ORM\JoinColumn(name="tournament_id", referencedColumnName="id")
     */
    protected $tournament;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime",nullable=false)
     */
    protected $date;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $goalsGame1Player1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $goalsGame1Player2;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $goalsGame2Player1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $goalsGame2Player2;

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

    public function getScore()
    {
        $score = $this->getRawScore();
        return $score[0] . " / " . $score[1];
    }

    protected function getRawScore()
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

        return array($win1, $win2);
    }

    /**
     * @param \Application\Entity\Tournament $tournament
     */
    public function setTournament($tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * @return \Application\Entity\Tournament
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    public function getWinner()
    {
        $score = $this->getRawScore();
        if ($score[0] > $score[1]) {
            return 1;
        }
        if ($score[0] < $score[1]) {
            return 2;
        }
        return 0;
    }

    public function isTeamOneWinner()
    {
        return $this->getWinner() == 1;
    }

    public function isTeamTwoWinner()
    {
        return $this->getWinner() == 2;
    }

}
