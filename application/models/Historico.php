<?php

namespace application\models;

use commons\Model;

/**
 * @Entity
 * @Table(name="historico")
 *
 */
class Historico extends Model {

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="text") */
    private $observacoes;

    public function setObservacoes($observacoes) {
        $this->observacoes = $observacoes;
    }

    public function getObservacoes() {
        return $this->observacoes;
    }

}
