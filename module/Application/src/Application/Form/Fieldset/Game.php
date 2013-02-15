<?php

namespace Application\Form\Fieldset;

use Application\Entity\Game as GameEntity;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class Game extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('game');
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new GameEntity());

        $this->add(
            array(
                'name' => 'id',
            )
        );

        $this->add(array(
            'name' => 'goalsTeamOne',
            'options' => array(
                'label' => 'Goals Team 1'
            ),
            'attributes' => array(
                'required' => 'required'
            )
        ));

        $this->add(array(
            'name' => 'goalsTeamTwo',
            'options' => array(
                'label' => 'Goals Team 2'
            ),
            'attributes' => array(
                'required' => 'required'
            )
        ));

    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'goalsTeamOne' => array(
                'required' => true,
            ),
            'goalsTeamTwo' => array(
                'required' => true,
            )
        );
    }

}