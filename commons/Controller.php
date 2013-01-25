<?php

/**
 * Controlador base. Ele é estendido por todos os controladores da aplicação
 *
 * @author Felipe Toscano de Azevedo Cardoso
 * @access public
 */

namespace commons;

use \ReflectionClass as ReflectionClass,    
    commons\View;

class Controller {
    public $view;
    protected $model;

    /**
     * Método construtor
     * @access public
     * @return void
     */
    public function __construct() {
        $this->view = new View();
        $this->model = $this->getModel();
    }
    
    /**
     * Carrega um modelo.
     * @access protected
     * @return Model
     */
    protected function getModel() {
        $modelName = str_replace('application\\controllers\\', '', get_class($this));
        if (file_exists(MODEL_PATH . "/" . $modelName . ".php")) {
            $model = "application\\models\\" . $modelName;
            $class = new ReflectionClass($model);
            if (!($class->isAbstract())) {
                $model = new $model();
                return $model;
            }
        }
    }

    /**
     * Redireciona URL
     * @access public
     * @return void
     */
    public function redirect($url) {
        $url = SITE_URL . $url;
        header("location: {$url}");
        exit;
    }

    /**
     * Monta a(s) mensagem(s) do sistema
     * @access public
     * @param $type string "success" or "error" or "warning"
     * @param $msg string mensagem a ser apresentada
     * @return void
     */
    public function msg($type, $msg) {
        switch ($type) {
            case "error":
            case "success":
            case "warning":
                if (!is_array($msg)) {
                    $lista = $this->view->session->get($type) != null ? $this->view->session->get($type) : array();
                    $lista[] = $msg;
                    $this->view->session->set($type, $lista);
                } else {
                    $this->view->session->set($type, $msg);
                }
                break;
            default:
                throw new Exception("Não foi possível montar a mensagem do sistema!");
                break;
        }
    }
}