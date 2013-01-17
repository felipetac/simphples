<?php

/**
 * Roteador XML. Responsável por incluir o controlador e executar o seu respectivo método informado
 *
 * @author Felipe Toscano de Azevedo Cardoso
 * @access public
 */

namespace commons;

class RouterXML {

    public static function run($url) {
        $xml = simplexml_load_file(SITE_PATH . "application/configs/urls.xml");
        $result = array();

        foreach ($xml->children() as $urll) {
            if ($urll->attributes()->name == $url) {
                $result["controller"] = isset($urll->controller) ? (string) $urll->controller : null;
                $result["method"] = isset($urll->action) ? (string) $urll->action : null;
                return $result;
            }
        }
    }

}