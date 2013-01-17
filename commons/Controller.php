<?php

/**
 * Controlador base. Ele é estendido por todos os controladores da aplicação
 *
 * @author Felipe Toscano de Azevedo Cardoso
 * @access public
 */

namespace commons;

use \ReflectionClass as ReflectionClass,
    commons\Session,
    commons\View;

class Controller {

    protected $session;
    public $view;
    protected $model;

    /**
     * Método construtor
     * @access public
     * @return void
     */
    public function __construct() {
        $this->session = new Session();
        $this->session->start();
        $this->view = new View();
        $this->model = $this->getModel();
        if ($this->session->get("success")) {
            $this->view->set("success", $this->session->get("success"));
            $this->session->destroy("success");
        }
        if ($this->session->get("error")) {
            $this->view->set("error", $this->session->get("error"));
            $this->session->destroy("error");
        }
        if ($this->session->get("warning")) {
            $this->view->set("warning", $this->session->get("warning"));
            $this->session->destroy("warning");
        }
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
                $ty = $type;
                break;
            case "success":
                $ty = $type;
                break;
            case "warning":
                $ty = $type;
                break;
            default:
                $ty = false;
        }
        if ($ty) {
            $lista = $this->session->get($ty) != null ? $this->session->get($ty) : array();
            $lista[] = $msg;
            $this->session->set($ty, $lista);
        } else {
            throw new Exception("Não foi possível montar a mensagem do sistema!");
        }
    }

}