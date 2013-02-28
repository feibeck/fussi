<?php
/**
 * Definition of Application\Validator\UniqueName
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Validator;

use Application\Entity\UniqueNameInterface;
use Zend\Validator\AbstractValidator;

class UniqueName extends AbstractValidator
{

    const NOT_UNIQUE   = 'notunique';

    /**
     * @var array
     */
    protected $messageTemplates = array(
	self::NOT_UNIQUE   => "The name is already in use"
    );


    /**
     * @var UniqueNameInterface
     */
    protected $repository;

    /**
     * @param UniqueNameInterface $repository
     */
    public function __construct(UniqueNameInterface $repository)
    {
	parent::__construct();
	$this->repository = $repository;
    }

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param  mixed $value
     * @return boolean
     */
    public function isValid($value)
    {
	$valid = $this->repository->isUniqueName($value);
	if (!$valid) {
	    $this->error(self::NOT_UNIQUE);
	}
	return $valid;
    }

}
