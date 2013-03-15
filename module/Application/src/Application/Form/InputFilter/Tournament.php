<?php
/**
 * Definition of Application\Entity\InputFilter\Tournament
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Form\InputFilter;

use \Application\Validator\UniqueName;
use Application\Model\Repository\TournamentRepository;
use \Zend\InputFilter\InputFilter;
use \Zend\Validator\NotEmpty;
use \Zend\Validator\StringLength;
use \Zend\Validator\Digits;

/**
 * Input filter for a Tournament entity. Used in combination with the
 * tournament form
 */
class Tournament extends InputFilter
{

    /**
     * The tournament repository is used to ensure a unique name of tournaments
     *
     * @param TournamentRepository $repository
     */
    public function __construct(TournamentRepository $repository)
    {

        $this->add(array(
            'name'     => 'name',
            'required' => true,
            'filters'  => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
            'validators' => array(
                new NotEmpty(),
                new StringLength(array(
                    'min'      => 3,
                    'max'      => 100,
                    'encoding' => 'UTF-8'
                )),
                new UniqueName($repository)
            ),
        ));

        $this->add(array(
            'name'     => 'games-per-match',
            'required' => true,
            'filters'  => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
            'validators' => array(
                array('name' => 'NotEmpty'),
                array('name' => 'Digits'),
                new \Zend\Validator\GreaterThan(array('min' => 0))
            ),
        ));

    }

}
