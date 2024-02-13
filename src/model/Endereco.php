<?php
namespace Src\Model;

class Endereco {
    private $id;
    private $id_usuario;
    private $logradouro;
    private $numero;
    private $complemento;
    private $cep;
    private $id_cidade;

    public function __construct($id_usuario = null, $logradouro = null, $numero = null, $complemento = null, $cep = null, $id_cidade = null) {
        $this->id_usuario = $id_usuario;
        $this->logradouro = $logradouro;
        $this->numero = $numero;
        $this->complemento = $complemento;
        $this->cep = $cep;
        $this->id_cidade = $id_cidade;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function getLogradouro() {
        return $this->logradouro;
    }

    public function setLogradouro($logradouro) {
        if (!$this->validateLogradouro($logradouro)) {
            throw new \InvalidArgumentException("Logradouro inválido.");
        }
        $this->logradouro = $logradouro;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function getComplemento() {
        return $this->complemento;
    }

    public function setComplemento($complemento) {
        $this->complemento = $complemento;
    }

    public function getCep() {
        return $this->cep;
    }

    public function setCep($cep) {
        if (!$this->validateCep($cep)) {
            throw new \InvalidArgumentException("CEP inválido.");
        }
        $this->cep = $cep;
    }

    public function getIdCidade() {
        return $this->id_cidade;
    }

    public function setIdCidade($id_cidade) {
        $this->id_cidade = $id_cidade;
    }

    private function validateLogradouro($logradouro) {
        return is_string($logradouro) && strlen($logradouro) >= 3;
    }

    private function validateCep($cep) {
        return preg_match('/^[0-9]{5}-?[0-9]{3}$/', $cep);
    }
}
