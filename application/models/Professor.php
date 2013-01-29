<?php

namespace application\models;

use commons\Database,
    commons\Model,
    Pagerfanta\Pagerfanta,
    Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 * @Entity
 * @Table(name="professor")
 */
class Professor extends Model {

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="string", nullable=false) */
    private $nome;

    /**
     * @ManyToMany(targetEntity="Turma", mappedBy="professores")
     */
    private $turmas;

    public function __construct() {
        $this->turmas = new ArrayCollection();
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

    public function setTurmas($turmas) {
        $this->turmas = $turmas;
    }

    public function getTurmas() {
        return $this->turmas;
    }

    public function getSelectedTurmas() {
        $arr = array();
        foreach ($this->getTurmas() as $turma) {
            $arr[] = $turma->getId();
        }
        return $arr;
    }

    public function getAllOptions() {
        $arr = array();
        $turma = new Turma();
        $turmas = $turma->findAll();
        foreach ($turmas as $item) {
            $arr[] = $item->getId();
        }
        return $arr;
    }

    public function getUnselectedTurmas() {
        $all = $this->getAllOptions();
        $selected = $this->getSelectedTurmas();
        foreach ($selected as $item) {
            $value = (string) $item;
            $key = array_search($value, $all);
            unset($all[$key]);
        }
        return $all;
    }

    public function setParams($params, $entityManager = null) {
        $em = isset($entityManager) ? $entityManager : Database::getEntityManager();
        $this->nome = empty($params['nome']) ? null : $params['nome'];
        $turmas = empty($params['turmas']) ? null : $params['turmas'];
        $selected = $this->getSelectedTurmas();

        if (!empty($selected)) {
            foreach ($selected as $index => $turma) {
                $turma = $em->find('application\models\Turma', $turma);
                $this->getTurmas()->removeElement($turma);
                $turma->getProfessores()->removeElement($this);
            }
        }

        if ($turmas) {
            foreach ($turmas as $index => $turma) {
                $turma = $em->find('application\models\Turma', $turma);
                if (!$this->getTurmas()->contains($turma)) {
                    $this->getTurmas()->add($turma);
                }
                if (!$turma->getProfessores()->contains($this)) {
                    $turma->getProfessores()->add($this);
                }
            }
        }
    }

    public function findByName($nome, $currentPage=1, $maxPerPage=20) {
        $em = Database::getEntityManager();
        $dql = "SELECT a FROM application\models\Professor a WHERE a.nome LIKE :nome ORDER BY a.nome ASC";
        $query = $em->createQuery($dql)
                ->setParameter("nome", "%".$nome."%");                
        
        $pager = new Pagerfanta(new \Pagerfanta\Adapter\DoctrineORMAdapter($query)); 
        $pager->setMaxPerPage($maxPerPage);
        $pager->setCurrentPage($currentPage);
        return $pager;
    }
}