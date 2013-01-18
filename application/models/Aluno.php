<?php

namespace application\models;

use commons\Database,
    commons\Model,
    application\models\Historico,
    application\models\Turma;

/**
 * @Entity
 * @Table(name="aluno")
 */
class Aluno extends Model {

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="string", nullable=false) */
    private $nome;

    /**
     * @OnetoOne(cascade={"remove"}, targetEntity="Historico")
     * @JoinColumn(name="id_historico", referencedColumnName="id")
     */
    private $historico;

    /**
     * @ManyToOne(targetEntity="Turma")
     * @JoinColumn(name="id_turma", referencedColumnName="id")
     */
    private $turma;

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setHistorico(Historico $historico) {
        $this->historico = $historico;
    }

    public function getHistorico() {
        return $this->historico;
    }

    public function setTurma(Turma $turma) {
        $this->turma = $turma;
    }

    public function getTurma() {
        return $this->turma;
    }

    public function setParams($params, $entityManager = null) {
        $em = isset($entityManager) ? $entityManager : Database::getEntityManager();
        $this->nome = empty($params['nome']) ? null : $params['nome'];
        $idTurma = empty($params['turma']) ? 0 : $params['turma'];
        $this->turma = $em->find('application\models\Turma', $idTurma);
        $obs = empty($params['observacao']) ? '' : $params['observacao'];

        if (empty($this->id)) {
            $historico = new Historico();
            $historico->setObservacoes($obs);
            $em->persist($historico);
            $this->historico = $historico;
        } else {
            $historico = $this->getHistorico();
            $historico->setObservacoes($obs);
            $this->historico = $historico;
        }
    }

    public function findByName($nome) {
        $em = Database::getEntityManager();
        $dql = "SELECT a FROM application\models\Aluno a WHERE a.nome LIKE :nome ORDER BY a.nome ASC";
        return $em->createQuery($dql)
                ->setParameter("nome", "%".$nome."%")
                ->getResult();
    }
}