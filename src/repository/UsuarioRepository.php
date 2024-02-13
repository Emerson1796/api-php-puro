<?php
namespace Src\Repository;

use Src\Database\Conexao;
use Src\Model\Usuario;

class UsuarioRepository {
    private $conexao;

    public function __construct() {
        $this->conexao = Conexao::getConn();
    }

    public function findAll() {
        $sql = 'SELECT * FROM usuarios WHERE deleted_at IS NULL';
        $stmt = $this->conexao->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $sql = 'SELECT u.id, u.nome, u.email, e.logradouro, e.numero, e.complemento, e.cep, c.nome AS nome_cidade, es.sigla AS sigla_estado
                FROM usuarios u
                LEFT JOIN enderecos e ON u.id = e.id_usuario
                LEFT JOIN cidades c ON e.id_cidade = c.id
                LEFT JOIN estados es ON c.id_estado = es.id
                WHERE u.id = ? AND u.deleted_at IS NULL';
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$id]);
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function save(Usuario $usuario) {
        if ($usuario->getId() !== null) {
            return $this->update($usuario);
        }

        $sql = 'INSERT INTO usuarios (nome, email, created_at, updated_at) VALUES (?, ?, NOW(), NOW())';
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            $usuario->getNome(),
            $usuario->getEmail()
        ]);

        return $this->conexao->lastInsertId();
    }

    private function update(Usuario $usuario) {
        $sql = 'UPDATE usuarios SET nome = ?, email = ?, updated_at = NOW() WHERE id = ?';
        $stmt = $this->conexao->prepare($sql);
        return $stmt->execute([
            $usuario->getNome(),
            $usuario->getEmail(),
            $usuario->getId()
        ]);
    }

    public function delete($id) {
        $sql = 'UPDATE usuarios SET deleted_at = NOW() WHERE id = ?';
        $stmt = $this->conexao->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function addEnderecoToUsuario($usuarioId, $enderecoId) {
        $sql = 'INSERT INTO usuario_endereco (usuario_id, endereco_id) VALUES (?, ?)';
        $stmt = $this->conexao->prepare($sql);
        return $stmt->execute([$usuarioId, $enderecoId]);
    }

    public function removeEnderecoFromUsuario($usuarioId, $enderecoId) {
        $sql = 'DELETE FROM usuario_endereco WHERE usuario_id = ? AND endereco_id = ?';
        $stmt = $this->conexao->prepare($sql);
        return $stmt->execute([$usuarioId, $enderecoId]);
    }

    public function removeAllEnderecosFromUsuario($usuarioId) {
        $sql = 'DELETE FROM usuario_endereco WHERE usuario_id = ?';
        $stmt = $this->conexao->prepare($sql);
        return $stmt->execute([$usuarioId]);
    }

    public function findEnderecosByUsuario($usuarioId) {
        $sql = 'SELECT e.* FROM enderecos e 
                INNER JOIN usuario_endereco ue ON e.id = ue.endereco_id 
                WHERE ue.usuario_id = ?';
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$usuarioId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
