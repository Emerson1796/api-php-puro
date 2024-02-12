<?php
namespace Src\Repository;

use Src\Database\Conexao;
use Src\Model\Estado;

class EstadoRepository {
    private $conexao;

    public function __construct() {
        $this->conexao = Conexao::getConn();
    }

    public function findAll() {
        $sql = 'SELECT * FROM estados WHERE deleted_at IS NULL';
        $stmt = $this->conexao->query($sql);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $sql = 'SELECT * FROM estados WHERE id = ? AND deleted_at IS NULL';
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function save(Estado $estado) {
        if ($estado->getId() !== null) {
            return $this->update($estado);
        }

        $sql = 'INSERT INTO estados (nome, sigla, created_at, updated_at) VALUES (?, ?, NOW(), NOW())';
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            $estado->getNome(),
            $estado->getSigla()
        ]);

        return $this->conexao->lastInsertId();
    }

    private function update(Estado $estado) {
        $sql = 'UPDATE estados SET nome = ?, sigla = ?, updated_at = NOW() WHERE id = ?';
        $stmt = $this->conexao->prepare($sql);
        return $stmt->execute([
            $estado->getNome(),
            $estado->getSigla(),
            $estado->getId()
        ]);
    }

    public function delete($id) {
        $sql = 'UPDATE estados SET deleted_at = NOW() WHERE id = ?';
        $stmt = $this->conexao->prepare($sql);
        return $stmt->execute([$id]);
    }
}
