<?php

namespace Application\Entity\InputFilter;

use Zend\InputFilter\InputFilter;

class Player extends InputFilter
{

    public function __construct($repository)
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
                     new \Zend\Validator\NotEmpty(),
                     new \Zend\Validator\StringLength(array(
                                                           'min'      => 3,
                                                           'max'      => 100,
                                                           'encoding' => 'UTF-8'
                                                      )),
		     new \Application\Validator\UniqueName($repository)
                 ),
            )
        );
    }

}
