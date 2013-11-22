<?php
/**
 * Definition of Application\Form\MatchForm
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

use Application\Model\Repository\PlayerRepository;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

abstract class MatchForm extends Form
{

    /**
     * @param PlayerRepository $playerRepository
     * @param int              $gameCount
     * @param int              $maxGoals
     */
    public function __construct($playerRepository, $gameCount, $maxGoals)
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
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'Application\Form\Fieldset\Game',
                    'options' => array(
                        'maxGoals' => $maxGoals
                    )
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
