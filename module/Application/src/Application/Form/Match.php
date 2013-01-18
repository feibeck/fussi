<?php

namespace Application\Form;

use Zend\Form\Form as ZendForm;
use Zend\Form\Element\Text as TextElement;

class Match extends ZendForm
{

    public function __construct()
    {
        parent::__construct('Match');

        $p1g1 = new TextElement('goalsGame1Player1');
        $p1g1->setAttribute('maxlength', 2);
        $p1g1->setAttribute('id', "goalsP1G1");
        $this->add($p1g1);

        $p2g1 = new TextElement('goalsGame1Player2');
        $p2g1->setAttribute('maxlength', 2);
        $p2g1->setAttribute('id', "goalsP2G1");
        $this->add($p2g1);

        $p1g2 = new TextElement('goalsGame2Player1');
        $p1g2->setAttribute('maxlength', 2);
        $p1g2->setAttribute('id', "goalsP1G2");
        $this->add($p1g2);

        $p2g2 = new TextElement('goalsGame2Player2');
        $p2g2->setAttribute('maxlength', 2);
        $p2g2->setAttribute('id', "goalsP2G2");
        $this->add($p2g2);
    }


}
