<?php

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @var Game[]
     *
     * @ORM\OneToMany(targetEntity="Application\Entity\Game", mappedBy="match", cascade={"persist"})
     */
    protected $games;

    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

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
        if (!isset($this->games[0])) {
            $this->games[0] = new Game();
            $this->games[0]->setMatch($this);
        }
        $this->games[0]->setGoalsTeamOne($goalsGame1Player1);
    }

    /**
     * @return int
     */
    public function getGoalsGame1Player1()
    {
        if (!isset($this->games[0])) {
            return 0;
        }
        return $this->games[0]->getGoalsTeamOne();
    }

    /**
     * @param int $goalsGame1Player2
     */
    public function setGoalsGame1Player2($goalsGame1Player2)
    {
        if (!isset($this->games[0])) {
            $this->games[0] = new Game();
            $this->games[0]->setMatch($this);
        }
        $this->games[0]->setGoalsTeamTwo($goalsGame1Player2);
    }

    /**
     * @return int
     */
    public function getGoalsGame1Player2()
    {
        if (!isset($this->games[0])) {
            return 0;
        }
        return $this->games[0]->getGoalsTeamTwo();
    }

    /**
     * @param int $goalsGame2Player1
     */
    public function setGoalsGame2Player1($goalsGame2Player1)
    {
        if (!isset($this->games[1])) {
            $this->games[1] = new Game();
            $this->games[1]->setMatch($this);
        }
        $this->games[1]->setGoalsTeamOne($goalsGame2Player1);
    }

    /**
     * @return int
     */
    public function getGoalsGame2Player1()
    {
        if (!isset($this->games[1])) {
            return 0;
        }
        return $this->games[1]->getGoalsTeamOne();
    }

    /**
     * @param int $goalsGame2Player2
     */
    public function setGoalsGame2Player2($goalsGame2Player2)
    {
        if (!isset($this->games[1])) {
            $this->games[1] = new Game();
            $this->games[1]->setMatch($this);
        }
        $this->games[1]->setGoalsTeamTwo($goalsGame2Player2);
    }

    /**
     * @return int
     */
    public function getGoalsGame2Player2()
    {
        if (!isset($this->games[1])) {
            return 0;
        }
        return $this->games[1]->getGoalsTeamTwo();
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

        foreach ($this->games as $game) {

            if ($game->getGoalsTeamOne() > $game->getGoalsTeamTwo()) {
                $win1++;
            } elseif ($game->getGoalsTeamTwo() > $game->getGoalsTeamOne()) {
                $win2++;
            }

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

    /**
     * @param Game $game
     */
    public function addGame(Game $game)
    {
        $game->setMatch($this);
        $this->games[] = $game;
    }

    public function setGames($games)
    {
        $this->games = new ArrayCollection($games);
        foreach ($this->games as $game) {
            $game->setMatch($this);
        }
    }

    /**
     * @return Game[]
     */
    public function getGames()
    {
        return $this->games;
    }

    public function getGameResults()
    {
        $results = array();
        foreach ($this->games as $game) {
            $results[] = $game->getGoalsTeamOne() . ':' . $game->getGoalsTeamTwo();
        }
        return $results;
    }

}
