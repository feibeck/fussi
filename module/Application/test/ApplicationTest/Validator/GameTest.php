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

namespace ApplicationTest\Validator;

use \Application\Validator\Game as GameValidator;

class GameTest extends \PHPUnit_Framework_TestCase
{

    public function testValidGame()
    {
        $validator = new GameValidator();
        $isValid = $validator->isValid(
            10,
            array('id' => 42, 'goalsTeamOne' => 10, 'goalsTeamTwo' => 3)
        );
        $this->assertTrue($isValid);
    }

    public function testGameWithoutWinner()
    {
        $validator = new GameValidator();
        $isValid = $validator->isValid(
            5,
            array('id' => 42, 'goalsTeamOne' => 5, 'goalsTeamTwo' => 5)
        );
        $this->assertFalse($isValid);
    }

    public function testGameWithTwoWinners()
    {
        $validator = new GameValidator();
        $isValid = $validator->isValid(
            10,
            array('id' => 42, 'goalsTeamOne' => 10, 'goalsTeamTwo' => 10)
        );
        $this->assertFalse($isValid);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testSettingInvalidMaxGoals()
    {
        $validator = new GameValidator(array('maxGoals' => 0));
    }

    public function testSetMaxGoals()
    {
        $validator = new GameValidator(array('maxGoals' => 7));
        $isValid = $validator->isValid(
            7,
            array('id' => 42, 'goalsTeamOne' => 7, 'goalsTeamTwo' => 3)
        );
        $this->assertTrue($isValid);
    }

}
