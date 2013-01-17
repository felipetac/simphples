<?php

/**
 * Classe responsável por obter os segments da URL informada
 *
 * @author Felipe Toscano de Azevedo Cardoso
 * @access public
 */

namespace commons;

class Request {

    private $_controller = "index";
    private $_method = "index";
    private $_args = array();

    /**
     * Método construtor
     * @access public
     * @return void
     */
    public function __construct() {
        // Algum controlador foi informado na URL? se não foi, mantêm que o controlador é o 'index'.
        //if( !isset($_GET["url"]) ) return false;
        //Obtem a string ds URL
        $this->_url = isset($_GET["url"]) ? $_GET["url"] : 'index';

        // Explode os segments da URL e os armazena em um Array
        $segments = explode('/', $this->_url);

        // Se o controlador foi realmente definido, retorna o nome dele.
        $this->_controller = ($c = array_shift($segments)) ? $c : 'index';

        // Se um método foi realmente requisitado, retorna o nome dele.
        $this->_method = ($m = array_shift($segments)) ? $m : 'index';

        // Se argumentos adicionais foram definidos, os retorna em Array.
        $this->_args = (isset($segments[0])) ? $segments : array();
    }

    /**
     * Retorna a string da URL
     * @access public
     * @return String
     */
    public function getURL() {
        return $this->_url;
    }

    /**
     * Retorna o nome do controlador
     * @access public
     * @return String
     */
    public function getController() {
        return $this->_controller;
    }

    /**
     * Retorna o nome do método
     * @access public
     * @return String
     */
    public function getMethod() {
        return $this->_method;
    }

    /**
     * Retorna os segmentos adicionais (argumentos)
     * @access public
     * @return Array
     */
    public function getArgs() {
        return $this->_args;
    }

}