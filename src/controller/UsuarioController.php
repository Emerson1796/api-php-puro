<?php
namespace Src\Controller;

use Src\Repository\UsuarioRepository;
use Src\Model\Usuario;

class UsuarioController {
    private $repository;

    public function __construct() {
        $this->repository = new UsuarioRepository();
    }

    public function index() {
        $usuarios = $this->repository->findAll();
        return $usuarios;
    }

    public function show($id) {
        $usuario = $this->repository->find($id);
        return $usuario;
    }

    public function create($nome, $email) {
        $usuario = new Usuario();
        $usuario->setNome($nome);
        $usuario->setEmail($email);
        $id = $this->repository->save($usuario);
        return $id;
    }

    public function update($id, $nome, $email) {
        $usuario = new Usuario();
        $usuario->setId($id);
        $usuario->setNome($nome);
        $usuario->setEmail($email);
        $success = $this->repository->save($usuario);
        return $success;
    }

    public function delete($id) {
        $success = $this->repository->delete($id);
        return $success;
    }
}
