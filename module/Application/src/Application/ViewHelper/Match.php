<?php
/**
 * Definition of Application\ViewHelper\Match
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\ViewHelper;

use Application\Entity\Tournament;
use Application\Entity\SingleMatch;
use Application\Entity\Player;
use Zend\View\Helper\AbstractHelper;
use \DateTime;

class Match extends AbstractHelper
{

    /**
     * @param DateTime $date
     * @param Tournament $tournament
     * @param SingleMatch[] $matches
     * @param Player $player1
     * @param Player $player2
     *
     * @return string
     */
    public function __invoke(
        DateTime $date,
        Tournament $tournament,
        array $matches,
        Player $player1,
        Player $player2
    )
    {

        $now = new \DateTime();
        $allow = $now->format('Ym') == $date->format('Ym');

        $out = '';

        if ($player1 != $player2) {

            $ok = false;
            foreach ($matches as $match) {

                $url = $this->getView()->url('match/edit', array(
                    'mid' => $match->getId()
                ));


                if ($match->isPlayedBy($player1, $player2)) {

                    $title = $player1->getName() . " vs. " . $player2->getName();
                    $content = sprintf("Game 1: %s / %s<br>Game 2: %s / %s",
                        $match->getGoalsGame1Player1(),
                        $match->getGoalsGame1Player2(),
                        $match->getGoalsGame2Player1(),
                        $match->getGoalsGame2Player2()
                    );

                    if ($allow) {
                        $content .= "<br><br><a href='" . $url . "' class='btn btn-small'>Edit</a>";
                    }

                    $out .= '<span title="' . $title . '" data-content="' . $content . '" class="match btn result">';
                    $out .= $match->getScore();
                    $out .= '</span>';
                    $ok = true;

                }
            }

            if (!$ok && $allow) {

                $url = $this->getView()->url('match/new/', array('tid' => $tournament->getId(), 'player1' => $player1->getId(), 'player2' => $player2->getId()));
                $out .= '<a href="' . $url . '" class="btn btn-small">Edit</a>';

            }

        }

        return $out;

    }

}
