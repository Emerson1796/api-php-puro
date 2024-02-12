<?php
namespace Src\Model;

class Estado {
    private $id;
    private $nome;
    private $sigla;

    public function __construct($nome = null, $sigla = null) {
        $this->setNome($nome);
        $this->setSigla($sigla);
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

    public function getSigla() {
        return $this->sigla;
    }

    public function setSigla($sigla) {
        if (!$this->validateSigla($sigla)) {
            throw new \InvalidArgumentException("Sigla inválida.");
        }
        $this->sigla = $sigla;
    }

    private function validateNome($nome) {
        return is_string($nome) && strlen($nome) >= 2;
    }

    private function validateSigla($sigla) {
        return preg_match('/^[A-Za-z]{2}$/', $sigla);
    }

}
