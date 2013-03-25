<?php
/**
 * Definition of Application\Form\Fieldset\Game
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Form\Fieldset;

use Application\Model\Entity\Game as GameEntity;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Zend\Validator\Between;
use Zend\Validator\Digits;
use \Application\Validator\Game as GameValidator;

class Game extends Fieldset implements InputFilterProviderInterface
{

    protected $maxGoals = 10;

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

    public function setOptions($options)
    {
        parent::setOptions($options);
        if (isset($options['maxGoals'])) {
            $this->setMaxGoals($options['maxGoals']);
        }
        return $this;
    }

    public function setMaxGoals($maxGoals)
    {
        $this->maxGoals = $maxGoals;
    }

    public function getMaxGoals()
    {
        return $this->maxGoals;
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {

        $digitsValidator  = new Digits();
        $betweenValidator = new Between(
            array(
                 'min' => 0,
                 'max' => $this->maxGoals
            )
        );

        return array(
            'goalsTeamOne' => array(
                'required' => true,
                'validators' => array(
                    $digitsValidator,
                    $betweenValidator,
                    new GameValidator($this->maxGoals)
                )
            ),
            'goalsTeamTwo' => array(
                'required' => true,
                'validators' => array(
                    $digitsValidator,
                    $betweenValidator,
                )
            )
        );

    }

}