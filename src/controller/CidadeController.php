<?php
namespace Src\Controller;

use Src\Repository\CidadeRepository;
use Src\Model\Cidade;

class CidadeController {
    private $repository;

    public function __construct() {
        $this->repository = new CidadeRepository();
    }

    public function index() {
        $cidades = $this->repository->findAll();
        return $cidades;
    }

    public function show($id) {
        $cidade = $this->repository->find($id);
        return $cidade;
    }

    public function create($nome, $id_estado) {
        $cidade = new Cidade($nome, $id_estado);
        $id = $this->repository->save($cidade);
        return $id;
    }

    public function update($id, $nome, $id_estado) {
        $cidade = new Cidade($nome, $id_estado);
        $cidade->setId($id);
        $success = $this->repository->save($cidade);
        return $success;
    }

    public function delete($id) {
        $success = $this->repository->delete($id);
        return $success;
    }

    public function findByEstado($id_estado) {
        $cidades = $this->repository->findByEstado($id_estado);
        return $cidades;
    }
}
