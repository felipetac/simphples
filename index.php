<?php

setlocale(LC_ALL, "pt_BR.utf-8", "pt_BR", 'portuguese-brazil', 'ptb', "pt_BR.iso-8859-1", "portuguese");
header("Content-Type: text/html; charset=utf-8",true);

define('SITE_URL','http://localhost/escola2/');
define('SITE_PATH',realpath(dirname("application")).'/');
define('CONTROLLER_PATH', SITE_PATH . 'application/controllers');
define('VIEW_PATH', SITE_PATH . 'application/views');
define('MODEL_PATH', SITE_PATH . 'application/models');

require 'vendor/autoload.php';

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