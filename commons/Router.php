<?php

/**
 * Roteador. Responsável por incluir o controlador e executar o seu respectivo método informado
 *
 * @author Felipe Toscano de Azevedo Cardoso
 * @access public
 */

namespace commons;

//use \Exception as Exception;

class Router {

    /**
     * Método responsável por obter o nome do controlador e do método e executá-los.
     * @access public
     * @return void
     */
    public static function run(Request $request) {
        $result = RouterXML::run($request->getURL());
        $controller = isset($result) ? $result["controller"] : $request->getController();
        $method = isset($result) ? $result["method"] : $request->getMethod();
        $args = $request->getArgs();

        // Controlador existe?
        if (file_exists(CONTROLLER_PATH . "/" . ucfirst($controller) . '.php')) {
            //Guarda o nome do controllador para reutilização
            $tempName = $controller;

            // Imposição do Namespace para classe
            $controller = "application\\controllers\\" . ucfirst($controller);

            // Verifica que se a classe solicitada existe;
            if (class_exists($controller)) {
                $controller = new $controller();
            } else {
                self::error("O controlador '" . $request->getController() . "' não foi encontrado!");
            }

            // O método informado na URL existe na classe? Se sim, use-o, caso contrário, dispare um erro.
            if (!is_callable(array($controller, $method))) {
                self::error("O método '" . $request->getMethod() . "' não foi encontrado!");
            }

            // Argumentos adicionais foram informados? Se sim, envie-os para o método chamado
            if (!empty($args)) {
                // Chama o método passado pra ele os argumentos adicionais
                call_user_func_array(array($controller, $method), $args);
            } else {
                if ($_POST) {
                    call_user_func(array($controller, $method), $_POST);
                } else {
                    call_user_func(array($controller, $method));
                }
            }

            //Reinderiza a view referênte
            $controller->view->render($tempName . "/" . $method);
        } else {
            // Controlador não encontrado, lança a exceção
            self::error("404 - A página '" . $request->getController() . "' não foi encontrada!");
        }
    }

    // Error
    protected static function error($msg) {
        throw new Exception($msg);
    }

}