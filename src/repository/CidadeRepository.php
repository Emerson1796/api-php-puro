<?php
namespace Src\Repository;

use Src\Database\Conexao;
use Src\Model\Cidade;

class CidadeRepository {
    private $conexao;

    public function __construct() {
        $this->conexao = Conexao::getConn();
    }

    public function findAll() {
        $sql = 'SELECT * FROM cidades WHERE deleted_at IS NULL';
        $stmt = $this->conexao->query($sql);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findByEstado($id_estado) {
        $sql = 'SELECT * FROM cidades WHERE id_estado = ? AND deleted_at IS NULL';
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$id_estado]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $sql = 'SELECT * FROM cidades WHERE id = ? AND deleted_at IS NULL';
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function save(Cidade $cidade) {
        if ($cidade->getId() !== null) {
            return $this->update($cidade);
        }

        $sql = 'INSERT INTO cidades (nome, id_estado, created_at, updated_at) VALUES (?, ?, NOW(), NOW())';
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            $cidade->getNome(),
            $cidade->getIdEstado()
        ]);

        return $this->conexao->lastInsertId();
    }

    private function update(Cidade $cidade) {
        $sql = 'UPDATE cidades SET nome = ?, id_estado = ?, updated_at = NOW() WHERE id = ?';
        $stmt = $this->conexao->prepare($sql);
        return $stmt->execute([
            $cidade->getNome(),
            $cidade->getIdEstado(),
            $cidade->getId()
        ]);
    }

    public function delete($id) {
        $sql = 'UPDATE cidades SET deleted_at = NOW() WHERE id = ?';
        $stmt = $this->conexao->prepare($sql);
        return $stmt->execute([$id]);
    }
}
