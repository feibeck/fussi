<?php
/**
 * Application entry point
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

chdir(dirname(__DIR__));
require 'init_autoloader.php';
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
