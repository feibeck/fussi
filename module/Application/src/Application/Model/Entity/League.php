<?php
/**
 * Definition of Application\Model\Entity\League
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
 * @ORM\Entity
 */
class League extends AbstractTournament
{

    /**
     * @param $data
     */
    public function exchangeArray($data)
    {
        $this->id            = (isset($data['id'])) ? $data['id'] : null;
        $this->name          = (isset($data['name'])) ? $data['name'] : null;
        $this->teamType      = (isset($data['team-type'])) ? $data['team-type'] : self::TYPE_SINGLE;
        $this->gamesPerMatch = (isset($data['games-per-match'])) ? $data['games-per-match'] : 1;
        if (isset($data['start-date'])) {
            $this->setStart($data['start-date']);
        } else {
            $this->setStart(new \DateTime());
        }
        $this->maxScore      = (isset($data['max-score'])) ? $data['max-score'] : self::MAXSCORE_DEFAULT;
     }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return array(
            'id'              => $this->id,
            'name'            => $this->name,
            'team-type'       => $this->teamType,
            'start-date'      => $this->start,
            'games-per-match' => $this->gamesPerMatch,
            'max-score'       => $this->maxScore
        );
    }

}