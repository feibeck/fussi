<?php

namespace Application;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature;
use Zend\Mvc\ModuleRouteListener;

class Module implements Feature\ControllerProviderInterface,
                        Feature\ConfigProviderInterface,
                        Feature\AutoloaderProviderInterface,
                        Feature\ViewHelperProviderInterface,
                        Feature\BootstrapListenerInterface
{

    public function onBootstrap(EventInterface $event)
    {
        $eventManager = $event->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getControllerConfig()
    {
        return include __DIR__ . '/config/controller.config.php';
    }

    public function getViewHelperConfig()
    {
        return include __DIR__ . '/config/view-helper.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

}
