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

use Application\ViewHelper\Ranking;
use Application\ViewHelper\Tournament;
use Doctrine\ORM\EntityManager;
use Zend\View\HelperPluginManager;


return array(
    'invokables' => array(
        'match'           => 'Application\ViewHelper\Match',
        'formGame'        => 'Application\ViewHelper\FormGame',
        'matchResult'     => 'Application\ViewHelper\MatchResult',
        'leaguePaginator' => 'Application\ViewHelper\LeaguePaginator',
    ),
    'factories' => array(
        'tournamentList' => function(HelperPluginManager $manager) {
            /** @var $em EntityManager */
            $em = $manager->getServiceLocator()
                      ->get("doctrine.entitymanager.orm_default");
            $repo = $em->getRepository('Application\Model\Entity\Tournament');
            return new Tournament($repo);
        },
        'ranking' => function(HelperPluginManager $manager) {
            /** @var $em EntityManager */
            $em = $manager->getServiceLocator()
                      ->get("doctrine.entitymanager.orm_default");
            return new Ranking(
                $em->getRepository('Application\Model\Entity\Match')
            );
        },
    )
);
