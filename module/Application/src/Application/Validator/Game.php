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

use \Zend\Validator\AbstractValidator;

class Game extends AbstractValidator
{

    const ONLY_ONE_WINNER = 'onlyOneWinner';
    const NEEDS_WINNER    = 'needsWinner';

    protected $messageTemplates = array(
        self::ONLY_ONE_WINNER => "Only one team can win the game",
        self::NEEDS_WINNER    => "The game needs a winner"
    );

    protected $maxGoals = 10;

    public function __construct($options = null)
    {
        parent::__construct($options);
        if (is_array($options) && isset($options['maxGoals'])) {
            $maxGoals = (int) $options['maxGoals'];
            if ($maxGoals < 1) {
                throw new \RuntimeException(
                    "The maxGoal option needs to be greater than 0"
                );
            }
            $this->maxGoals = $maxGoals;
        }
    }

    public function isValid($value, $context = array())
    {
        if (isset($context['id'])) {
            unset($context['id']);
        }
        $values = array_values($context);
        if ($values[0] == $this->maxGoals && $values[1] == $this->maxGoals) {
            $this->error(self::ONLY_ONE_WINNER);
            return false;
        }
        if ($values[0] != $this->maxGoals && $values[1] != $this->maxGoals) {
            $this->error(self::NEEDS_WINNER);
            return false;
        }
        return true;
    }

}
