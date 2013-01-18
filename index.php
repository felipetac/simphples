<?php

require_once 'application/configs/defines.php';
require_once 'vendor/autoload.php';

$classLoader = new Doctrine\Common\ClassLoader();
$classLoader->register();

use commons\Router,
    commons\Request;

//application\controllers\Error as ErrorController;
try {
    Router::run(new Request());
} catch (Exception $e) {
    echo $e->getMessage();
    //new ErrorController($e->getMessage());
}