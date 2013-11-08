<?php
/**
 * Definition of Application\Form\League
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */
namespace Application\Form;

use Application\Model\Entity\League as LeagueEntity;
use \Zend\Form\Form;

class League extends Form
{

    public function __construct()
    {
        parent::__construct('League');

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name',
            'options' => array(
                'label' => 'Name'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'games-per-match',
            'options' => array(
                'label' => 'Games per match',
            ),
            'attributes' => array(
                'maxlength' => 2
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'games-per-match',
            'options' => array(
                'label' => 'Games per match',
            ),
            'attributes' => array(
                'maxlength' => 2
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'team-type',
            'options' => array(
                'label' => 'Match-Type',
                'value_options' => array(
                    LeagueEntity::TYPE_TEAM   => 'Team',
                    LeagueEntity::TYPE_SINGLE => 'Single Player',
                ),
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'max-score',
            'options' => array(
                'label' => 'Max. score to win a game',
            ),
            'attributes' => array(
                'maxlength' => 2
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'start-date',
            'options' => array(
                'label' => 'Start date'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submit',
            'options' => array(
                'type'  => 'submit'
            )
        ));
        $this->get('submit')->setValue('Save');

    }

}
