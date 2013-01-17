<?php

/**
 * Modelo base para os modelos da aplicação.
 *
 * @author Felipe Toscano de Azevedo Cardoso
 * @access public
 */

namespace commons;

use commons\Database;

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
}