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
        $sql = 'SELECT * FROM usuarios WHERE id = ? AND deleted_at IS NULL';
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
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
}
