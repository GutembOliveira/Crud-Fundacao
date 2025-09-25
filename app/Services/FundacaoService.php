<?php
namespace app\Services;

use app\Models\Fundacao;
use app\Repositories\FundacaoRepository;
use Exception;

class FundacaoService
{
    private FundacaoRepository $repository;

    public function __construct()
    {
        $this->repository = new FundacaoRepository();
    }

    public function cadastrarFundacao(array $data): bool
    {
        // Validações básicas
        if (empty($data['nome']) || empty($data['cnpj']) || empty($data['email']) || empty($data['telefone']) || empty($data['instituicao'])) {
            throw new Exception("Todos os campos são obrigatórios.");
        }

        // if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        //     throw new Exception("Email inválido.");
        // }

        // if (!preg_match('/^\d{14}$/', preg_replace('/\D/', '', $data['cnpj']))) {
        //     throw new Exception("CNPJ inválido. Deve conter 14 dígitos numéricos.");
        // }

        // if (!preg_match('/^\+?\d{10,15}$/', preg_replace('/\D/', '', $data['telefone']))) {
        //     throw new Exception("Telefone inválido. Deve conter entre 10 e 15 dígitos numéricos.");
        // }

        $fundacao = new Fundacao(
            $data['nome'],
            preg_replace('/\D/', '', $data['cnpj']),
            $data['email'],
            preg_replace('/\D/', '', $data['telefone']),
            $data['instituicao']
        );

        $sucesso =  $this->repository->save($fundacao);
        return $sucesso;
    }
    public function deletarFundacao(string $cnpj): bool
        {
            return $this->repository->deleteByCnpj($cnpj);
        }

    public function getByCnpj(string $cnpj): ?array
    {
        return $fundacao = $this->repository->getByCnpj($cnpj);
    }

    public function atualizarFundacao(array $data): bool
    {
        // Validações básicas
        if (empty($data['nome']) || empty($data['cnpj']) || empty($data['email']) || empty($data['telefone']) || empty($data['instituicao'])) {
            throw new Exception("Todos os campos são obrigatórios.");
        }

        $fundacao = new Fundacao(
            $data['nome'],
            preg_replace('/\D/', '', $data['cnpj']),
            $data['email'],
            preg_replace('/\D/', '', $data['telefone']),
            $data['instituicao']
        );  

        $sucesso =  $this->repository->update($fundacao);
        return $sucesso;
    }
    public function listarFundacoes(): array
    {
        return $this->repository->getAll();
    }
}