<?php
// src/Model/Usuario.php
namespace Src\Model;

class Usuario {
    private $id;
    private $nome;
    private $email;
    private $created_at;
    private $updated_at;
    private $deleted_at;

    public function __construct($nome = null, $email = null) {
        $this->nome = $nome;
        $this->email = $email;
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

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        if (!$this->validateEmail($email)) {
            throw new \InvalidArgumentException("Email inválido.");
        }
        $this->email = $email;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }

    public function getDeletedAt() {
        return $this->deleted_at;
    }

    public function setDeletedAt($deleted_at) {
        $this->deleted_at = $deleted_at;
    }

    private function validateNome($nome) {
        return is_string($nome) && strlen($nome) >= 2;
    }

    private function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

}
