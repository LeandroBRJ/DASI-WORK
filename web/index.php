<?php
// chemin d'accès aux sources de l'application
defined('APPLICATION_PATH')
	|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'app'));

// définition de l'include_path
set_include_path(implode(PATH_SEPARATOR, array(
	realpath(APPLICATION_PATH . '/../src'),
)));

/*
 * Instancie et lance l'application
 */
phpinfo();die;
include 'Mvc/Application.php';
$application = new Mvc\Application(array(
	Mvc\Application::OPTION_APPLICATION_DIRECTORY => APPLICATION_PATH
));
$application->run();