<?php
// src/Controller/EstadoController.php
namespace Src\Controller;

use Src\Repository\EstadoRepository;
use Src\Model\Estado;

class EstadoController {
    private $repository;

    public function __construct() {
        $this->repository = new EstadoRepository();
    }

    public function index() {
        $estados = $this->repository->findAll();
        return $estados;
    }

    public function show($id) {
        $estado = $this->repository->find($id);
        return $estado;
    }

    public function create($nome, $sigla) {
        $estado = new Estado($nome, $sigla);
        $id = $this->repository->save($estado);
        return $id;
    }

    public function update($id, $nome, $sigla) {
        $estado = new Estado($nome, $sigla);
        $estado->setId($id);
        $success = $this->repository->save($estado);
        return $success;
    }

    public function delete($id) {
        $success = $this->repository->delete($id);
        return $success;
    }
}
