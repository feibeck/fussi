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
        'Application\Controller\Index' => function(ControllerManager $cm) {
            $sm = $cm->getServiceLocator();
            $em = $sm->get("doctrine.entitymanager.orm_default");
            $controller = new Controller\IndexController(
                $em->getRepository('Application\Model\Entity\Match'),
                $em->getRepository('Application\Model\Entity\Tournament')
            );
            return $controller;
        },
        'Application\Controller\PlayTournament' => function(ControllerManager $cm) {
            $controller = new Controller\PlayTournamentController();
            return $controller;
        },
        'Application\Controller\Player' => function(ControllerManager $cm) {
            $sm = $cm->getServiceLocator();
            $em = $sm->get("doctrine.entitymanager.orm_default");
            return new Controller\PlayerController(
                $em->getRepository('Application\Model\Entity\Player')
            );
        },
        'Application\Controller\Tournament' => function(ControllerManager $cm) {
            $sm = $cm->getServiceLocator();
            $em = $sm->get("doctrine.entitymanager.orm_default");
            return new Controller\TournamentController(
                $em->getRepository('Application\Model\Entity\Tournament'),
                $em->getRepository('Application\Model\Entity\Player')
            );
        },
        'Application\Controller\Dashboard' => function(ControllerManager $cm) {
            $sm = $cm->getServiceLocator();
            /** @var $em EntityManager */
            $em = $sm->get("doctrine.entitymanager.orm_default");
            return new Controller\DashboardController(
                $em->getRepository('Application\Model\Entity\Match'),
                $em->getRepository('Application\Model\Entity\Tournament')
            );
        },
        'Application\Controller\Match' => function(ControllerManager $cm) {
            $sm = $cm->getServiceLocator();
            $em = $sm->get("doctrine.entitymanager.orm_default");
            return new Controller\MatchController(
                $em->getRepository('Application\Model\Entity\Match'),
                $em->getRepository('Application\Model\Entity\Tournament'),
                $em->getRepository('Application\Model\Entity\Player')
            );
        },
    )
);
