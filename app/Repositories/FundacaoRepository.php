<?php
namespace app\Repositories;

require __DIR__ . '/../../config/Database.php';

use app\Models\Fundacao;
use PDO;

class FundacaoRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = \app\config\Database::getConnection();
    }

    public function save(Fundacao $fundacao): bool
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO fundacoes (nome, cnpj, email, telefone, instituicao) 
             VALUES (:nome, :cnpj, :email, :telefone, :instituicao)"
        );

        return $stmt->execute([
            ':nome' => $fundacao->nome,
            ':cnpj' => $fundacao->cnpj,
            ':email' => $fundacao->email,
            ':telefone' => $fundacao->telefone,
            ':instituicao' => $fundacao->instituicao
        ]);
    }

    public function update(Fundacao $fundacao): bool
    {
        $stmt = $this->conn->prepare(
            "UPDATE fundacoes SET nome=:nome, email=:email, telefone=:telefone, instituicao=:instituicao 
             WHERE cnpj=:cnpj"
        );

        return $stmt->execute([
            ':nome' => $fundacao->nome,
            ':email' => $fundacao->email,
            ':telefone' => $fundacao->telefone,
            ':instituicao' => $fundacao->instituicao,
            ':cnpj' => $fundacao->cnpj
        ]);
    }

    public function getAll(): array
    {
        $stmt = $this->conn->query("SELECT * FROM fundacoes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteByCnpj(string $cnpj): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM fundacoes WHERE cnpj = :cnpj");
        $stmt->execute([':cnpj' => $cnpj]);
        return $stmt->rowCount() > 0; // Retorna true se algum registro foi deletado
    }

    public function getByCnpj(string $cnpj): array|null
    {
        $stmt = $this->conn->prepare("SELECT * FROM fundacoes WHERE cnpj = :cnpj");
        $stmt->execute([':cnpj' => $cnpj]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result !== false ? $result : null;
    }
}
