<?php
// src/Model/Cidade.php
namespace Src\Model;

class Cidade {
    private $id;
    private $nome;
    private $id_estado;

    public function __construct($nome = null, $id_estado = null) {
        $this->nome = $nome;
        $this->id_estado = $id_estado;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        if (!$this->validateNome($nome)) {
            throw new \InvalidArgumentException("Nome inválido.");
        }
        $this->nome = $nome;
    }

    public function getIdEstado() {
        return $this->id_estado;
    }

    public function setIdEstado($id_estado) {
        $this->id_estado = $id_estado;
    }

    private function validateNome($nome) {
        return is_string($nome) && strlen($nome) >= 2;
    }
}
