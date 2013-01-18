<?php

namespace application\models;

use commons\Model,
    commons\Database,
    Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 * @Entity
 * @Table(name="turma")
 */
class Turma extends Model {

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="string", nullable=false) */
    private $nome;

    /** @OneToMany(targetEntity="Aluno", mappedBy="turma")  */
    private $alunos;

    /**
     * @ManyToMany(targetEntity="Professor")
     * @JoinTable(name="professor_turma",
     * joinColumns={@JoinColumn(name="id_turma",referencedColumnName="id")},
     * inverseJoinColumns={@JoinColumn(name="id_professor",referencedColumnName="id")}
     * )
     */
    private $professores;

    public function __construct() {
        $this->professores = new ArrayCollection();
    }

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

    public function getAlunos() {
        return $this->alunos;
    }

    public function setProfessores($professores) {
        $this->professores = $professores;
    }

    public function getProfessores() {
        return $this->professores;
    }

    public function setParams($params) {
        $this->nome = (isset($params['nome']) AND $params['nome'] != '') ? $params['nome'] : null;
    }

    public function findByName($nome) {
        $em = Database::getEntityManager();
        $dql = "SELECT a FROM application\models\Turma a WHERE a.nome LIKE :nome ORDER BY a.nome ASC";
        return $em->createQuery($dql)
                ->setParameter("nome", "%".$nome."%")
                ->getResult();
    }

}