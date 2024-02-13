<?php
namespace Src\Repository;

use Src\Database\Conexao;
use Src\Model\Endereco;

class EnderecoRepository {
    private $conexao;

    public function __construct() {
        $this->conexao = Conexao::getConn();
    }

    public function findAll() {
        $sql = 'SELECT * FROM enderecos WHERE deleted_at IS NULL';
        $stmt = $this->conexao->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $sql = 'SELECT * FROM enderecos WHERE id = ? AND deleted_at IS NULL';
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function findByUsuario($usuarioId) {
        $sql = 'SELECT e.* FROM enderecos e
                INNER JOIN usuario_endereco ue ON e.id = ue.endereco_id
                WHERE ue.usuario_id = ? AND e.deleted_at IS NULL';
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$usuarioId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function save(Endereco $endereco) {
        if ($endereco->getId() !== null) {
            return $this->update($endereco);
        }

        $sql = 'INSERT INTO enderecos (logradouro, numero, complemento, cep, id_cidade, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())';
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            $endereco->getLogradouro(),
            $endereco->getNumero(),
            $endereco->getComplemento(),
            $endereco->getCep(),
            $endereco->getIdCidade()
        ]);

        return $this->conexao->lastInsertId();
    }

    private function update(Endereco $endereco) {
        $sql = 'UPDATE enderecos SET logradouro = ?, numero = ?, complemento = ?, cep = ?, id_cidade = ?, updated_at = NOW() WHERE id = ?';
        $stmt = $this->conexao->prepare($sql);
        return $stmt->execute([
            $endereco->getLogradouro(),
            $endereco->getNumero(),
            $endereco->getComplemento(),
            $endereco->getCep(),
            $endereco->getIdCidade(),
            $endereco->getId()
        ]);
    }

    public function delete($id) {
        $sql = 'UPDATE enderecos SET deleted_at = NOW() WHERE id = ?';
        $stmt = $this->conexao->prepare($sql);
        return $stmt->execute([$id]);
    }
}
