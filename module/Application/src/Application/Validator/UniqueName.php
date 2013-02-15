<?php

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
