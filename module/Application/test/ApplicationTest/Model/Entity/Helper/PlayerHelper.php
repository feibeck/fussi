<?php
/**
 * Definition of ApplicationTest\Model\Entity\Helper\PlayerHelper
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace ApplicationTest\Model\Entity\Helper;

use Application\Model\Entity\Player;

class PlayerHelper implements \ArrayAccess
{

    /**
     * @var Player[]
     */
    public $player = array();

    /**
     * @param int $id
     *
     * @return Player
     */
    public function createPlayer($id = null)
    {
        if ($id == null) {
            $id = uniqid();
        }
        $player = new Player();
        $player->setId($id);
        $this->player[] = $player;
        return $player;
    }

    /**
     * @param int $offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->player[$offset]);
    }

    /**
     * @param int $offset
     *
     * @return Player
     */
    public function offsetGet($offset)
    {
        return $this->player[$offset];
    }

    /**
     * @param int    $offset
     * @param Player $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->player[$offset] = $value;
    }

    /**
     * @param int $offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->player[$offset]);
    }

}