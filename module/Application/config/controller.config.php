<?php

use Application\Controller;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\ControllerManager;

return array(
    'factories' => array(
        'Application\Controller\Index' => function(ControllerManager $cm) {
            $sm = $cm->getServiceLocator();
            $controller = new Controller\IndexController(
                $sm->get("doctrine.entitymanager.orm_default")
            );
            return $controller;
        },
        'Application\Controller\Player' => function(ControllerManager $cm) {
            $sm = $cm->getServiceLocator();
            return new Controller\PlayerController(
                $sm->get("doctrine.entitymanager.orm_default")
            );
        },
        'Application\Controller\Tournament' => function(ControllerManager $cm) {
            $sm = $cm->getServiceLocator();
            return new Controller\TournamentController(
                $sm->get("doctrine.entitymanager.orm_default")
            );
        },
        'Application\Controller\Dashboard' => function(ControllerManager $cm) {
            $sm = $cm->getServiceLocator();
            /** @var $em EntityManager */
            $em = $sm->get("doctrine.entitymanager.orm_default");
            return new Controller\DashboardController(
                $em->getRepository('Application\Entity\Match'),
                $em->getRepository('Application\Entity\Tournament')
            );
        },
        'Application\Controller\Match' => function(ControllerManager $cm) {
            $sm = $cm->getServiceLocator();
            return new Controller\MatchController(
                $sm->get("doctrine.entitymanager.orm_default")
            );
        },
    )
);
