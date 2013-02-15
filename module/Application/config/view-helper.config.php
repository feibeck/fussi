<?php

use Application\ViewHelper\Ranking;
use Doctrine\ORM\EntityManager;
use Zend\View\HelperPluginManager;

return array(
    'invokables' => array(
       'match' => 'Application\ViewHelper\Match',
       'formGame' => 'Application\ViewHelper\FormGame',
    ),
    'factories' => array(
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
