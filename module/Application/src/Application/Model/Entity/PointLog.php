<?php
/**
 * Definition of Application\Model\Entity\PointLog
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
 * @ORM\Entity(repositoryClass="Application\Model\Repository\PointLogRepository")
 * @ORM\Table(name="pointlog")
 */
class PointLog
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $currentPoints1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $currentPoints2;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $newPoints1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $newPoints2;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $chance1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $chance2;

    /**
     * @var SingleMatch|DoubleMatch
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\Match")
     * @ORM\JoinColumn(name="match_id", referencedColumnName="id")
     */
    protected $match;

    /**
     * @var PointLogPlayer[]
     *
     * @ORM\OneToMany(targetEntity="Application\Model\Entity\PointLogPlayer", mappedBy="pointlog", cascade={"persist"})
     */
    protected $playerPointLogs;

    /**
     * @param Match $match
     */
    public function __construct(Match $match)
    {
        $this->playerPointLogs = new ArrayCollection();

        $this->match = $match;

        $this->currentPoints1 = $this->getPointsParticipant1($match);
        $this->currentPoints2 = $this->getPointsParticipant2($match);
    }

    /**
     * @return int
     */
    public function getCurrentPoints1()
    {
        return $this->currentPoints1;
    }

    /**
     * @return int
     */
    public function getCurrentPoints2()
    {
        return $this->currentPoints2;
    }

    /**
     * @return int
     */
    public function getDifference1()
    {
        return $this->newPoints1 - $this->getCurrentPoints1();
    }

    /**
     * @return int
     */
    public function getDifference2()
    {
        return $this->newPoints2 - $this->getCurrentPoints2();
    }

    /**
     * @param Player $player
     *
     * @return int
     */
    public function getDifference(Player $player)
    {
        $side = $this->match->getSideForPlayer($player);
        if ($side == 1) {
            return $this->getDifference1();
        } else {
            return $this->getDifference2();
        }
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DoubleMatch|SingleMatch
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * @param int $newPoints1
     */
    public function setNewPoints1($newPoints1)
    {
        $this->newPoints1 = $newPoints1;
    }

    /**
     * @param int $newPoints2
     */
    public function setNewPoints2($newPoints2)
    {
        $this->newPoints2 = $newPoints2;
    }

    /**
     * @param int $chance1
     */
    public function setChance1($chance1)
    {
        $this->chance1 = $chance1;
    }

    /**
     * @param int $chance2
     */
    public function setChance2($chance2)
    {
        $this->chance2 = $chance2;
    }

    /**
     * @return int
     */
    public function getChance1()
    {
        return $this->chance1;
    }

    /**
     * @return int
     */
    public function getChance2()
    {
        return $this->chance2;
    }

    /**
     * @param Player $player
     *
     * @return int
     */
    public function getChance(Player $player)
    {
        $side = $this->match->getSideForPlayer($player);
        if ($side == 1) {
            return $this->chance1;
        } else {
            return $this->chance2;
        }
    }

    /**
     * @return int
     */
    protected function getPointsParticipant1()
    {
        if ($this->match instanceof SingleMatch) {
            return $this->match->getPlayer1()->getPoints();
        } else if ($this->match instanceof DoubleMatch) {
            return $this->getPointsForTeam($this->match->getTeamOne());
        }
    }

    /**
     * @return int
     */
    protected function getPointsParticipant2()
    {
        if ($this->match instanceof SingleMatch) {
            return $this->match->getPlayer2()->getPoints();
        } else if ($this->match instanceof DoubleMatch) {
            return $this->getPointsForTeam($this->match->getTeamTwo());
        }
    }

    /**
     * @param Team $team
     *
     * @return float
     */
    protected function getPointsForTeam($team)
    {
        $sum = $team->getAttackingPlayer()->getPoints() + $team->getDefendingPlayer()->getPoints();
        return round($sum / 2);
    }

    /**
     * @param PointLogPlayer $playerLog
     */
    public function addPlayerLog(PointLogPlayer $playerLog)
    {
        $this->playerPointLogs[] = $playerLog;
    }

}
