<?php

namespace Application\Validator;

use Zend\Validator\AbstractValidator;

use Application\Entity\PlayerRepository;

class UniquePlayerName extends AbstractValidator
{

    const NOT_UNIQUE   = 'notunique';

    /**
     * @var array
     */
    protected $messageTemplates = array(
	self::NOT_UNIQUE   => "The name is already in use"
    );


    /**
     * @var PlayerRepository
     */
    protected $userRepository;

    /**
     * @param PlayerRepository $userRepository
     */
    public function __construct(PlayerRepository $userRepository)
    {
	parent::__construct();
	$this->userRepository = $userRepository;
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
	$valid = $this->userRepository->isUniqueName($value);
	if (!$valid) {
	    $this->error(self::NOT_UNIQUE);
	}
	return $valid;
    }

}
