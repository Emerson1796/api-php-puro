<?php
namespace Src\Controller;

use Src\Repository\UsuarioRepository;
use Illuminate\Support\Facades\Response;
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
        $rawData = $this->repository->find($id);
        $usuario = null;
        $enderecosArray = [];

        foreach ($rawData as $row) {
            if (!$usuario) {
                $usuario = [
                    'id' => $row['id'],
                    'nome' => $row['nome'],
                    'email' => $row['email'],
                ];
            }

            if ($row['logradouro']) {
                $enderecoCompleto = "{$row['logradouro']}, {$row['numero']}" . ($row['complemento'] ? ", {$row['complemento']}" : '') . " - {$row['cep']} - {$row['nome_cidade']} - {$row['sigla_estado']}";
                $enderecosArray[] = $enderecoCompleto;
            }
        }

        return Response::json([
            "user" => $usuario,
            "addresses" => $enderecosArray
        ]);
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
