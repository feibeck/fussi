<?php
/**
 * Controller configuration for the module
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

use Application\Controller;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\ControllerManager;

return array(
    'factories' => array(
        'Application\Controller\Tournament' => function(ControllerManager $cm) {
            $sm = $cm->getServiceLocator();
            $em = $sm->get("doctrine.entitymanager.orm_default");
            $controller = new Controller\TournamentController(
                $em->getRepository('Application\Model\Entity\AbstractTournament'),
                $em->getRepository('Application\Model\Entity\Match')
            );
            return $controller;
        },
        'Application\Controller\Player' => function(ControllerManager $cm) {
            $sm = $cm->getServiceLocator();
            $em = $sm->get("doctrine.entitymanager.orm_default");
            return new Controller\PlayerController(
                $em->getRepository('Application\Model\Entity\Player'),
                $em->getRepository('Application\Model\Entity\PointLogPlayer')
            );
        },
        'Application\Controller\TournamentSetup' => function(ControllerManager $cm) {
            $sm = $cm->getServiceLocator();
            $em = $sm->get("doctrine.entitymanager.orm_default");
            return new Controller\TournamentSetupController(
                $em->getRepository('Application\Model\Entity\AbstractTournament'),
                $em->getRepository('Application\Model\Entity\Player')
            );
        },
        'Application\Controller\Ranking' => function(ControllerManager $cm) {
            $sm = $cm->getServiceLocator();
            /** @var $em EntityManager */
            $em = $sm->get("doctrine.entitymanager.orm_default");
            return new Controller\RankingController(
                $em->getRepository('Application\Model\Entity\Match'),
                $em->getRepository('Application\Model\Entity\AbstractTournament'),
                $em->getRepository('Application\Model\Entity\PointLog'),
                $em->getRepository('Application\Model\Entity\Player'),
                $sm->get('console')
            );
        },
        'Application\Controller\Dashboard' => function(ControllerManager $cm) {
            $sm = $cm->getServiceLocator();
            /** @var $em EntityManager */
            $em = $sm->get("doctrine.entitymanager.orm_default");
            return new Controller\DashboardController(
                $em->getRepository('Application\Model\Entity\Match'),
                $em->getRepository('Application\Model\Entity\AbstractTournament')
            );
        },
        'Application\Controller\Match' => function(ControllerManager $cm) {
            $sm = $cm->getServiceLocator();
            $em = $sm->get("doctrine.entitymanager.orm_default");
            return new Controller\MatchController(
                $em->getRepository('Application\Model\Entity\Match'),
                $em->getRepository('Application\Model\Entity\AbstractTournament'),
                $em->getRepository('Application\Model\Entity\Player'),
                $em->getRepository('Application\Model\Entity\PlannedMatch'),
                $em->getRepository('Application\Model\Entity\PointLog')
            );
        },
        'Application\Controller\Feed' => function(ControllerManager $cm) {
            $sm = $cm->getServiceLocator();
            $em = $sm->get('doctrine.entitymanager.orm_default');

            $matchFeeder = new \Application\Model\MatchFeeder(
                new \Zend\Feed\Writer\Feed,
                $em->getRepository('Application\Model\Entity\Match')
            );
            $matchFeeder->setTitle('Fussi: Recent matches');

            $baseUrl = sprintf('%s%s', 'http://', $_SERVER['HTTP_HOST']);
            $matchFeeder->setUrl($baseUrl);

            return new Controller\FeedController($matchFeeder);
        },
    )
);
