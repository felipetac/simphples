<?php

/**
 * Modelo base para os modelos da aplicação.
 *
 * @author Felipe Toscano de Azevedo Cardoso
 * @access public
 */

namespace commons;

use commons\Database,
    Respect\Validation\Validator as v;

class Model {

    public function delete($id) {
        $em = Database::getEntityManager();
        $entity = $em->find(get_class($this), $id);
        if ($entity) {
            $em->remove($entity);
            $em->flush();
            return true;
        }
    }
    
    public function save($params) {
        $em = Database::getEntityManager();
        $id = empty($params['id']) ? 0 : $params['id'];
        $entity = $em->find(get_class($this), $id);
        if (empty($entity)) {
            $entity = $this;
        }
        $entity->setParams($params, $em);
        $this->erros = $entity->validate();
        
        if (!is_array($this->erros)){
            $em->persist($entity);
            $em->flush();
            return true;
        }
        return $this->erros;
    }

    public function find($id, $entity = false) {
        $em = Database::getEntityManager();

        if ($entity) {
            return $em->find($entity, $id);
        } else {
            return $em->find(get_class($this), $id);
        }
    }

    public function findAll($orderBy = null, $order = 'ASC') {
        $em = Database::getEntityManager();
        if ($orderBy && $order) {
            if ($order == 'DESC')
                $dql = "SELECT e FROM " . get_class($this) . " e ORDER BY e." . $orderBy . " DESC";
            else
                $dql = "SELECT e FROM " . get_class($this) . " e ORDER BY e." . $orderBy . " ASC";
        }
        else {
            $dql = "SELECT e FROM " . get_class($this) . " e";
        }
        return $em->createQuery($dql)->getResult();
    }
    
    protected function setDate($date){
        return $date && v::date()->validate($date) ? new \DateTime(implode('-',array_reverse(explode('/', $date)))) : $date;
    }
    
    protected function getDate($date, $format='d/m/Y'){
        return $date && v::date()->validate($date) ? $date->format($format) : $date;
    }
}