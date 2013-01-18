<?php

require_once 'application/configs/defines.php';
require_once 'vendor/autoload.php';

$classLoader = new Doctrine\Common\ClassLoader();
$classLoader->register();

use commons\Database;

$database = new Database();
$entityManager = $database->getEntityManager();

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($entityManager)
));
