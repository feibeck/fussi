<?php

use Application\ViewHelper\Ranking;
use Application\ViewHelper\Tournament;
use Doctrine\ORM\EntityManager;
use Zend\View\HelperPluginManager;


return array(
    'invokables' => array(
       'match' => 'Application\ViewHelper\Match',
    ),
    'factories' => array(
        'tournamentList' => function(HelperPluginManager $manager) {
            /** @var $em EntityManager */
            $em = $manager->getServiceLocator()
                      ->get("doctrine.entitymanager.orm_default");
            $repo = $em->getRepository('Application\Entity\Tournament');
            return new Tournament($repo);
        },
        'ranking' => function(HelperPluginManager $manager) {
            /** @var $em EntityManager */
            $em = $manager->getServiceLocator()
                      ->get("doctrine.entitymanager.orm_default");
            return new Ranking(
                $em->getRepository('Application\Entity\Match')
            );
        },
    )
);
