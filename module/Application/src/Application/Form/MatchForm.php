<?php

namespace Application\Form;

use \Application\Entity\PlayerRepository;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

abstract class MatchForm extends Form
{

    /**
     * @param PlayerRepository $playerRepository
     * @param int              $gameCount
     */
    public function __construct($playerRepository, $gameCount)
    {
        parent::__construct('match');

        $this->setAttribute('method', 'post')
             ->setHydrator(new MatchHydrator($playerRepository))
             ->setInputFilter(new InputFilter());

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'games',
            'options' => array(
                'label' => 'Games',
                'count' => $gameCount,
                'should_create_template' => false,
                'allow_add' => false,
                'target_element' => array(
                    'type' => 'Application\Form\Fieldset\Game'
                )
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf'
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Send'
            )
        ));
    }

}
