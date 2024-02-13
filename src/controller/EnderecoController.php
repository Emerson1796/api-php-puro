<?php
namespace Src\Controller;

use Src\Repository\EnderecoRepository;
use Src\Model\Endereco;

class EnderecoController {
    private $repository;

    public function __construct() {
        $this->repository = new EnderecoRepository();
    }

    public function index() {
        $enderecos = $this->repository->findAll();
        return $enderecos;
    }

    public function show($id) {
        $endereco = $this->repository->find($id);
        return $endereco;
    }

    public function create($logradouro, $numero, $complemento, $cep, $id_cidade) {
        $endereco = new Endereco();
        $endereco->setLogradouro($logradouro);
        $endereco->setNumero($numero);
        $endereco->setComplemento($complemento);
        $endereco->setCep($cep);
        $endereco->setIdCidade($id_cidade);
        $id = $this->repository->save($endereco);
        return $id;
    }

    public function update($id, $logradouro, $numero, $complemento, $cep, $id_cidade) {
        $endereco = new Endereco();
        $endereco->setId($id);
        $endereco->setLogradouro($logradouro);
        $endereco->setNumero($numero);
        $endereco->setComplemento($complemento);
        $endereco->setCep($cep);
        $endereco->setIdCidade($id_cidade);
        $success = $this->repository->save($endereco);
        return $success;
    }

    public function delete($id) {
        $success = $this->repository->delete($id);
        return $success;
    }
}
