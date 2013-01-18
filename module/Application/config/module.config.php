<?php
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
                    'add' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => 'tournament/add',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Tournament',
                                'action'     => 'add',
                            )
                        )
                    ),
                    'players' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => 'tournament/:id/players',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Tournament',
                                'action' => 'players'
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
                        'controller' => 'Application\Controller\Tournament',
                        'action' => 'list'
                    )
                )
            ),
            'matchresult' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/matchresult/:id/:year/:month/:player1/:player2',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'matchresult',
                    ),
                ),
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
            )
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'Application\Controller\Index' => function(Zend\Mvc\Controller\ControllerManager $cm) {
                $sm = $cm->getServiceLocator();
                $controller = new \Application\Controller\IndexController(
                    $sm->get("doctrine.entitymanager.orm_default")
                );
                $startDate = new \DateTime();
                $startDate->setDate(2012, 11, 01);
                $startDate->setTime(0, 0, 0);
                $controller->setStartDate($startDate);
                return $controller;
            },
            'Application\Controller\Player' => function(Zend\Mvc\Controller\ControllerManager $cm) {
                $sm = $cm->getServiceLocator();
                return new \Application\Controller\PlayerController(
                    $sm->get("doctrine.entitymanager.orm_default")
                );
            },
            'Application\Controller\Tournament' => function(Zend\Mvc\Controller\ControllerManager $cm) {
                $sm = $cm->getServiceLocator();
                return new \Application\Controller\TournamentController(
                    $sm->get("doctrine.entitymanager.orm_default")
                );
            },
            'Application\Controller\Dashboard' => function(Zend\Mvc\Controller\ControllerManager $cm) {
                return new \Application\Controller\DashboardController();
            },
        )
    ),
    'doctrine' => array(
        'driver' => array(
            'Application_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Application/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Application\Entity' => 'Application_driver'
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
    ),
    'view_helpers' => array(
       'invokables' => array(
          'match' => 'Application\ViewHelper\Match',
       ),
    ),
);
