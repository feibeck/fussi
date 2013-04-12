<?php
/**
 * Definition of ApplicationTest\Controller\DashboardControllerTest
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace ApplicationTest\Conroller;

use Application\Controller\DashboardController;

class DashboardControllerTest extends \PHPUnit_Framework_TestCase
{

    public function testDashboard()
    {

        $matchRepository = $this->getMock(
            'Application\Model\Repository\MatchRepository',
            array(
                'getLastMatches'
            ),
            array(),
            '',
            false
        );
        $matchRepository->expects($this->once())
            ->method('getLastMatches')
            ->will($this->returnValue('lastmatches'));

        $tournamentRepository = $this->getMock(
            'Application\Model\Repository\TournamentRepository',
            array(),
            array(),
            '',
            false
        );
        $tournamentRepository->expects($this->once())
            ->method('findAllActive')
            ->will($this->returnValue('alltournaments'));

        $controller = new DashboardController(
            $matchRepository,
            $tournamentRepository
        );

        $viewModel = $controller->dashboardAction();

        $this->assertEquals(
            array('matches' => 'lastmatches', 'tournaments' => 'alltournaments'),
            $viewModel
        );
    }

}

