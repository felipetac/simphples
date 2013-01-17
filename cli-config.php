<?php

//define('SITE_URL','http://localhost/escola2/');
define('SITE_PATH',realpath(dirname("application")).'/');
//define('CONTROLLER_PATH', SITE_PATH . 'application/controllers');
//define('VIEW_PATH', SITE_PATH . 'application/views');
define('MODEL_PATH', SITE_PATH . 'application/models');

require 'vendor/autoload.php';

$classLoader = new Doctrine\Common\ClassLoader();
$classLoader->register();

use Commons\Database;

$database = new Database();
$entityManager = $database->getEntityManager();

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($entityManager)
));
