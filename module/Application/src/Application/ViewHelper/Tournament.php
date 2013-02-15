<?php

namespace Application\ViewHelper;

use Zend\View\Helper\AbstractHelper;

class Tournament extends AbstractHelper
{
    /**
     * @var \Application\Entity\Tournament[]
     */
    protected $tournaments;

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
