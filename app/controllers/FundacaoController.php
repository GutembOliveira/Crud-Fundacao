<?php
namespace App\Controllers;
use app\Services\FundacaoService;
class FundacaoController
{
    private $service;
    public function formulario()
    {
        require __DIR__ . '/../views/cadastroFundacao.php';
    }
    public function __construct()
    {
        $this->service = new FundacaoService();
    }

    //validações
    private function validarCnpj(string $cnpj): bool
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);
        if (strlen($cnpj) != 14) {
            return false;
        }
        if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
            return false;
        }
        $peso1 = [5,4,3,2,9,8,7,6,5,4,3,2];
        $peso2 = [6,5,4,3,2,9,8,7,6,5,4,3,2];
        for ($t = 12; $t <= 13; $t++) {
            $soma = 0;
            $peso = ($t == 12) ? $peso1 : $peso2;

            for ($i = 0; $i < $t; $i++) {
                $soma += $cnpj[$i] * $peso[$i];
            }

            $resto = $soma % 11;
            $digito = ($resto < 2) ? 0 : 11 - $resto;

            if ($cnpj[$t] != $digito) {
                return false;
            }
        }

        return true;
    }

    private function validarEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function validarTelefone(string $telefone): bool
    {
       
         return preg_match('/^\d{8,11}$/', $telefone) === 1;
    }
    public function cadastrar()
    {
        $dados = $_POST;

        if (empty($dados['nome']) || empty($dados['cnpj']) || empty($dados['email']) || empty($dados['instituicao'])) {
            $mensagem = "⚠️ Preencha todos os campos obrigatórios.";
        } 
            //sanitização de dados
            $dados['cnpj'] = $this->apenasNumeros($dados['cnpj']);
            $dados['telefone'] = $this->apenasNumeros($dados['telefone']);
            if (empty($dados['nome']) || empty($dados['cnpj']) || empty($dados['email']) || empty($dados['instituicao'])) {
                $erros[] = " Preencha todos os campos obrigatórios.";
            }
            //validações de dados
            if (!empty($dados['cnpj']) && !$this->validarCnpj($dados['cnpj'])) {
                $erros[] = " CNPJ inválido.";
            }

            if (!empty($dados['email']) && !$this->validarEmail($dados['email'])) {
                $erros[] = " E-mail inválido.";
            }

            if (!empty($dados['telefone']) && !$this->validarTelefone($dados['telefone'])) {
                $erros[] = " Telefone inválido. ";
            }
              if (!empty($erros)) {
                $mensagem = implode("<br>", $erros);
                $tipo = "error";
                require __DIR__ . '/../views/cadastroFundacao.php';
                return;
            }

            $save = $this->service->cadastrarFundacao($dados);
            if ($save) {
            $mensagem = "Fundação '{$dados['nome']}' cadastrada com sucesso!";
            $tipo = "success";}
            else {
                $mensagem = "CNPJ já cadastrado.";
                $tipo = "error";
            }
        
         require __DIR__ . '/../views/cadastroFundacao.php';
    }

    public function deletarFundacao()
    {
        $cnpj = $_POST['cnpj'] ?? null;
        //$data = json_decode(file_get_contents('php://input'), true);
        //$cnpj = $data['cnpj'] ?? null;

        if ($cnpj) {
            $deleted = $this->service->deletarFundacao($cnpj);
            if ($deleted) {
                http_response_code(200);
                header("Location: /"); 
                exit;

            } else {
                http_response_code(404);
                echo json_encode(['message' => "Fundação com CNPJ $cnpj não encontrada."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => "CNPJ é obrigatório para deletar uma fundação."]);
        }
    }
    public function listarFundacoes()
    {
        $fundacoes = $this->service->listarFundacoes();
        require __DIR__ . '/../views/home.php';
    }

     public function buscarFundacao()
    {
        $cnpj = $_GET['cnpj'] ?? null;
        if (!empty($cnpj)) {
            $fundacao = $this->service->getByCnpj($cnpj);
            $fundacoes = $fundacao ? [$fundacao] : [];
        } else {
            $fundacoes = $this->service->listarFundacoes();
        }
        require __DIR__ . '/../views/home.php';
    }
    public function editarFundacao()
{
    $cnpj = $_GET['cnpj'] ?? null;

    if ($cnpj) {
        $fundacao = $this->service->getByCnpj($cnpj);

        if ($fundacao) {
            $dados = $fundacao;
            $modo = "editar";
            require __DIR__ . '/../views/cadastroFundacao.php';
            return;
        }
    }
}

private function apenasNumeros(string $valor): string
{
    return preg_replace('/\D/', '', $valor);
}

public function atualizarFundacao()
{
    $dados = $_POST;

    if (!empty($dados['cnpj'])) {
        $atualizado = $this->service->atualizarFundacao($dados);

        if ($atualizado) {
            header("Location: /?sucesso=Fundação atualizada com sucesso");
            exit;
        } else {
            header("Location: /?erro=Erro ao atualizar a fundação");
            exit;
        }
    }
}
}
