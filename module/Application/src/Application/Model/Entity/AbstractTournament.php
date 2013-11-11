<?php
/**
 * Definition of Application\Model\Entity\Game
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
 * Base class for all match types. Matches of all types are stored in a
 * single database table (Doctrine's Single Table Inheritance).
 *
 * @see http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/inheritance-mapping.html#single-table-inheritance
 *
 * @ORM\Entity(repositoryClass="Application\Model\Repository\TournamentRepository")
 * @ORM\Table(name="tournament")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"league" = "Application\Model\Entity\League", "double" = "Application\Model\Entity\Tournament"})
 */
abstract class AbstractTournament
{

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=150)
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="Application\Model\Entity\Player")
     * @ORM\JoinTable(name="tournament_players",
     *      joinColumns={@ORM\JoinColumn(name="tournament_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="player_id", referencedColumnName="id")}
     *      )
     */
    protected $players;

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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Player[]
     */
    public function getPlayers()
    {
        return $this->players->toArray();
    }

    /**
     * @return string
     */
    public function getType()
    {
        if ($this instanceof Tournament) {
            return "Tournament";
        } else {
            return "League";
        }
    }

    public function addPlayer(Player $player)
    {
        $this->players->add($player);
    }

}
