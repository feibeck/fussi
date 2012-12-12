<?php

namespace Application\ViewHelper;

use Zend\View\Helper\AbstractHelper;

class Match extends AbstractHelper
{

    public function __invoke($date, $matches, $player1, $player2)
    {

        $now = new \DateTime();
        $allow = $now->format('Ym') == $date->format('Ym');

        $out = '';

        if ($player1 != $player2) {

            $ok = false;
            foreach ($matches as $match) {
                if ($match->isPlayedBy($player1, $player2)) {

                    $out .= $match->getScore();
                    $ok = true;

                }
            }

            if (!$ok && $allow) {

                $url = $this->getView()->url('matchresult', array(
                    'year' => $date->format('Y'),
                    'month' => $date->format('m'),
                    'player1' => $player1->getId(),
                    'player2' => $player2->getId(),
                ));

                $out .= '<a href="' . $url . '" class="btn btn-small">Edit</a>';

            }

        }

        return $out;

    }

}
