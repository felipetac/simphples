<?php

/**
 * Classe para trabalhar com banco de dados usando Doctrine.
 *
 * @author Felipe Toscano de Azevedo Cardoso
 * @access public
 */

namespace commons;

use Doctrine\ORM\Tools\Setup,
    Doctrine\ORM\EntityManager;

final class Database {

    public static function getEntityManager() {
        Setup::registerAutoloadPEAR();
        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration(array(MODEL_PATH), $isDevMode);
        $conn = parse_ini_file(SITE_PATH . 'application/configs/database.ini');
        return EntityManager::create($conn, $config);
    }

}