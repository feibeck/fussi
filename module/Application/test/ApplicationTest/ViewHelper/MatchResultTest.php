<?php
/**
 * Definition of ApplicationTest\ViewHelper\MatchResultTest
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace ApplicationTest\ViewHelper;


class MatchResultTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeSingleGame()
    {
        $match = $this->getMock('Application\Entity\SingleMatch', array('getGames'));
        $game = $this->getGameMock(1, 10);

        $match->expects($this->once())->method('getGames')->will($this->returnValue(array($game)));

        $helper = new \Application\ViewHelper\MatchResult();
        $output = $helper->__invoke($match);

        $this->assertEquals('1:10', $output);
    }

    public function testInvokeMultipleGames()
    {
        $match = $this->getMock('Application\Entity\SingleMatch', array('getGames'));
        $games = array();
        $games[] = $this->getGameMock(1, 10);
        $games[] = $this->getGameMock(10, 5);

        $match->expects($this->once())->method('getGames')->will($this->returnValue($games));

        $helper = new \Application\ViewHelper\MatchResult();
        $output = $helper->__invoke($match);

        $this->assertEquals('1:10, 10:5', $output);
    }

    protected function getGameMock($goalsOne, $goalsTwo)
    {
        $game = $this->getMock('Application\Entity\Game', array('getGoalsTeamOne', 'getGoalsTeamTwo'));
        $game->expects($this->once())->method('getGoalsTeamOne')->will($this->returnValue($goalsOne));
        $game->expects($this->once())->method('getGoalsTeamTwo')->will($this->returnValue($goalsTwo));
        return $game;
    }
}
