<?php
/**
 * Fußi
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


use Application\Model\Entity\AbstractTournament;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;

class MatchMode extends AbstractValidator
{

    const BEST_OF_START_AT_THREE   = 'startAtThree';
    const BEST_OF_NEEDS_ODD_NUMBER = 'needsOddNumber';

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $messageTemplates = array(
        self::BEST_OF_START_AT_THREE   => "You need to play at least three games in best-of matches",
        self::BEST_OF_NEEDS_ODD_NUMBER => "You need to play an odd number of games for best-of matches"
    );

    /**
     * @var string
     */
    protected $matchModeFieldKey;

    /**
     * @param string $matchModeFieldKey
     */
    function __construct($matchModeFieldKey)
    {
        parent::__construct();
        $this->matchModeFieldKey = $matchModeFieldKey;
    }

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param mixed $value
     * @param array $context
     *
     * @return bool
     *
     * @throws \RuntimeException
     */
    public function isValid($value, $context = array())
    {
        $this->setValue($value);

        if (!isset($context[$this->matchModeFieldKey])) {
            throw new \RuntimeException('Match mode for validator not defined');
        }
        $mode = (int) $context[$this->matchModeFieldKey];

        if ($mode === AbstractTournament::MODE_EXACTLY) {

            return true;

        } else if ($mode === AbstractTournament::MODE_BEST_OF) {

            if ($value == 1) {
                $this->error(self::BEST_OF_START_AT_THREE);
                return false;
            }

            if (!($value & 1)) {
                $this->error(self::BEST_OF_NEEDS_ODD_NUMBER);
                return false;
            }

            return true;

        } else {

            throw new \RuntimeException('Invalid match mode given for validation');

        }

    }

}
