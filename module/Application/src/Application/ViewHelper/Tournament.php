<?php
/**
 * Definition of Application\ViewHelper\Tournament
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

use Zend\View\Helper\AbstractHelper;

class Tournament extends AbstractHelper
{
    /**
     * @var \Application\Model\Entity\League[]
     */
    protected $tournaments;

    /**
     * @param $repo
     */
    public function __construct($repo) {
        $tournaments = $repo->findAll();
        $this->tournaments = $tournaments;
    }

    public function __invoke()
    {
        $out = "";
        $nl = "\n";

        foreach($this->tournaments as $tournament) {
            $out .= '<li role="presentation">'.$nl;
            $out .= '<a href="';
            $out .= $this->getView()->url('tournament/show', array('id' => $tournament->getId()));
            $out .= '" tabindex="-1" role="menuitem">'.$nl;
            $out .= $tournament->getName();
            $out .= '</a>'.$nl.'</li>'.$nl;
        }

        return $out;
    }

}
