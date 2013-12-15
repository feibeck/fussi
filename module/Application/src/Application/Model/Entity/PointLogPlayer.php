<?php
/**
 * Definition of Application\Model\Entity\PointLogPlayer
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
 * @ORM\Entity(repositoryClass="Application\Model\Repository\PointLogPlayerRepository")
 * @ORM\Table(name="pointlogplayer")
 */
class PointLogPlayer
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="\Application\Model\Entity\Player")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     */
    protected $player;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $pointsBefore;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $pointsAfter;

    /**
     * @var PointLog
     *
     * @ORM\ManyToOne(targetEntity="Application\Model\Entity\PointLog", inversedBy="playerPointLogs")
     * @ORM\JoinColumn(name="pointlog_id", referencedColumnName="id")
     */
    protected $pointLog;

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
     * @param \Application\Model\Entity\Player $player
     */
    public function setPlayer($player)
    {
        $this->player = $player;
    }

    /**
     * @return \Application\Model\Entity\Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param \Application\Model\Entity\PointLog $pointLog
     */
    public function setPointLog($pointLog)
    {
        $this->pointLog = $pointLog;
    }

    /**
     * @return \Application\Model\Entity\PointLog
     */
    public function getPointLog()
    {
        return $this->pointLog;
    }

    /**
     * @param int $pointsAfter
     */
    public function setPointsAfter($pointsAfter)
    {
        $this->pointsAfter = $pointsAfter;
    }

    /**
     * @return int
     */
    public function getPointsAfter()
    {
        return $this->pointsAfter;
    }

    /**
     * @param int $pointsBefore
     */
    public function setPointsBefore($pointsBefore)
    {
        $this->pointsBefore = $pointsBefore;
    }

    /**
     * @return int
     */
    public function getPointsBefore()
    {
        return $this->pointsBefore;
    }

}
