<?php

chdir(dirname(__DIR__));
require 'init_autoloader.php';
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
