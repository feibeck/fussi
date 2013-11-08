<?php
/**
 * Module configuration file
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

return array(
    'router' => array(
        'routes' => array(
            'dashboard' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Dashboard',
                        'action'     => 'dashboard'
                    ),
                ),
            ),
            'tournament-test' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/tt',
                    'defaults' => array(
                        'controller' => 'Application\Controller\PlayTournament',
                        'action'     => 'index'
                    ),
                ),
                'child_routes' => array(
                    'list' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route'    => '/list',
                            'defaults' => array(
                                'controller' => 'Application\Controller\PlayTournament',
                                'action'     => 'list'
                            ),
                        ),
                    ),
                ),
            ),
            'tournament' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/',
                ),
                'child_routes' => array(
                    'show' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => ':id/[:year/:month]',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Index',
                                'action'     => 'index',
                                'year'       => date('Y'),
                                'month'      => date('m')
                            )
                        )
                    ),
                    'show-tournament' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => 't/:id',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Tournament',
                                'action'     => 'show',
                            )
                        )
                    ),
                    'add-league' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => 'tournament/add-league',
                            'defaults' => array(
                                'controller' => 'Application\Controller\TournamentSetup',
                                'action'     => 'addLeague',
                            )
                        )
                    ),
                    'add-tournament' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => 'tournament/add-tournament',
                            'defaults' => array(
                                'controller' => 'Application\Controller\TournamentSetup',
                                'action'     => 'addTournament',
                            )
                        )
                    ),
                    'players' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => 'tournament/:id/players',
                            'defaults' => array(
                                'controller' => 'Application\Controller\TournamentSetup',
                                'action' => 'players'
                            )
                        )
		            ),
                    'addplayer' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => 'tournament/:id/addplayer',
                            'defaults' => array(
                                'controller' => 'Application\Controller\TournamentSetup',
                                'action' => 'addplayer'
                            )
                        )
                    )
                )
            ),
            'tournaments' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/tournaments',
                    'defaults' => array(
                        'controller' => 'Application\Controller\TournamentSetup',
                        'action' => 'list'
                    )
                )
            ),
            'players' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/players',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Player',
                        'action' => 'list'
                    )
                )
            ),
            'player' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/player',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Player',
                    ),
                ),
                'child_routes' => array(
                    'add' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/add',
                            'defaults' => array(
                                'action' => 'add'
                            ),
                        ),
                    )
                )
            ),
            'match' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/match',
                ),
                'child_routes' => array(
                    'new' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/new/:tid[/:player1/:player2]',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Match',
                                'action'     => 'new',
                                'player1'    => null,
                                'player2'    => null
                            )
                        )
                    ),
                    'edit' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/edit/:mid',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Match',
                                'action'     => 'edit',
                            )
                        )
                    ),
                )
            ),
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'Application_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Application/Model/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Application\Model\Entity' => 'Application_driver'
                )
            )
        )
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'paginationcontrol'       => __DIR__ . '/../view/pagination_control.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    )
);
