<?php
namespace app\Models;

class Fundacao
{
    public string $nome;
    public string $cnpj;
    public string $email;
    public string $telefone;
    public string $instituicao;

    public function __construct($nome, $cnpj, $email, $telefone, $instituicao)
    {
        $this->nome = $nome;
        $this->cnpj = $cnpj;
        $this->email = $email;
        $this->telefone = $telefone;
        $this->instituicao = $instituicao;
    }

    public function toArray(): array
    {
        return [
            'nome' => $this->nome,
            'cnpj' => $this->cnpj,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'instituicao' => $this->instituicao,
        ];
    }
}
