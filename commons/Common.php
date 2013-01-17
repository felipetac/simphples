<?php

/**
 * Funções comuns
 *
 * @author Felipe Toscano de Azevedo Cardoso
 * @access public
 */

namespace commons;

class Common {

    private function __construct() {
        // Construtor privado, classe não pode ser instanciada.
    }

    /**
     * Valida se o dado está em branco.
     * @access public
     * @param String $dado.
     * @return Boolean
     */
    public static function validarEmBranco($dado) {
        return empty($dado);
    }

    /**
     * Valida um e-mail.
     * @access public
     * @param String $email E-mail.
     * @return Boolean
     */
    public static function validarEmail($email) {
        return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email);
    }

    /**
     * Redireciona para uma URL.
     * @access public
     * @param String $url URL a ser requisitada.
     * @return void
     */
    public static function redir($url = "") {
        header('location: ' . SITE_URL . '/' . $url);
        exit;
    }

}