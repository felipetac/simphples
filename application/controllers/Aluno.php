<?php

namespace application\controllers;

use application\models\Turma,
    commons\Controller;

final class Aluno extends Controller {

    public function __construct() {
        parent::__construct();
        $this->view->set("mainNavItem", "Alunos");
    }

    public function index() {
        $this->buscar();
    }

    public function buscar($params = null) {
        $this->view->set("title", "Aluno");
        $this->model->setParams($params);
        $nome = $this->model->getNome();
        $result = $this->model->findByName($nome);
        $result = empty($result) ? null : $result;
        $this->view->set("resultado", $result);
        $this->view->set("nome", $nome);
        $this->view->render("aluno/index");
    }

    public function novo() {
        $this->view->set("title", "Novo Aluno");
        $turma = new Turma();
        $this->view->set("turmas", $turma->findAll("nome"));
        $this->view->render("aluno/gravar");
    }

    public function editar($id) {
        $this->view->set("title", "Editar Aluno");
        $turma = new Turma();
        $this->view->set("turmas", $turma->findAll("nome"));
        $model = $this->model->find($id);        
        $this->view->set("aluno", $model);
        $this->view->render("aluno/gravar");
    }

    public function excluir($id) {
        if ($this->model->delete((int) $id)) {
            $this->msg("success", "Item excluído com sucesso!");
        } else {
            $this->msg("error", "Item não encontrado ou já excluido(s)!");
        }
        $this->redirect("aluno");
    }

    public function gravar($params) {
        if ($this->model->save($params)) {
            $this->msg("success", "Item salvo com sucesso!");
        } else {
            $this->msg("error", "Item não pode ser salvo!");            
            $this->model->setParams($params);
            $this->view->set("title", "Editar Aluno");
            $turma = new Turma();
            $this->view->set("turmas", $turma->findAll("nome"));
            $this->view->set("aluno", $this->model);
            $this->view->render("aluno/gravar");
        }
        $this->redirect("aluno");
    }

}