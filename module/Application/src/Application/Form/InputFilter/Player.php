<?php
/**
 * Definition of Application\Form\InputFilter\Player
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

use Application\Model\Repository\PlayerRepository;
use \Application\Validator\UniqueName;
use \Zend\InputFilter\InputFilter;
use \Zend\Validator\NotEmpty;
use \Zend\Validator\StringLength;

/**
 * Input filter for a Player entity. Used in combination with the player form
 */
class Player extends InputFilter
{

    /**
     * The player repository is used to ensure a unique name of players
     *
     * @param PlayerRepository $repository
     */
    public function __construct(PlayerRepository $repository)
    {
        $this->add(
            array(
            'name'       => 'name',
            'required'   => true,
            'filters'    => array(
                array('name' => 'Zend\Filter\StringTrim'),
                array('name' => 'Zend\Filter\StripTags'),
            ),
            'validators' => array(
                new NotEmpty(),
                new StringLength(
                    array(
                        'min'      => 3,
                        'max'      => 100,
                        'encoding' => 'UTF-8'
                    )
                ),
                new UniqueName($repository)
            )
            )
        );
    }

}
