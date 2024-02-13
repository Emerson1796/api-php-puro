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

    public function create($nome, $email, $enderecoIds = []) {
        $usuario = new Usuario();
        $usuario->setNome($nome);
        $usuario->setEmail($email);
        $usuarioId = $this->repository->save($usuario);
        
        foreach ($enderecoIds as $enderecoId) {
            $this->repository->addEnderecoToUsuario($usuarioId, $enderecoId);
        }

        return $usuarioId;
    }

    public function update($id, $nome, $email, $enderecoIds = []) {
        $usuario = new Usuario();
        $usuario->setId($id);
        $usuario->setNome($nome);
        $usuario->setEmail($email);
        $success = $this->repository->save($usuario);

        $this->repository->removeAllEnderecosFromUsuario($id);

        foreach ($enderecoIds as $enderecoId) {
            $this->repository->addEnderecoToUsuario($id, $enderecoId);
        }

        return $success;
    }

    public function delete($id) {
        $success = $this->repository->delete($id);
        $this->repository->removeAllEnderecosFromUsuario($id);
        return $success;
    }
}
