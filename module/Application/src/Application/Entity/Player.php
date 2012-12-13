<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Application\Entity\PlayerRepository")
 * @ORM\Table(name="player")
 */
class Player
{

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $name;

    /**
     * @param $data
     */
    public function exchangeArray($data)
    {
	$this->id = (isset($data['id'])) ? $data['id'] : null;
	$this->name = (isset($data['name'])) ? $data['name'] : null;
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
	return get_object_vars($this);
    }

    /**
     * @param int $id
     *
     * @return Player Fluid interface
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
     *
     * @return Player Fluent interface
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}
