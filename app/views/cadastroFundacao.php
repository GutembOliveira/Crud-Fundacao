<?php
$dados = $dados ?? ($_POST ?? []);
$mensagem = $mensagem ?? '';
$tipo = $tipo ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Fundação de Apoio</title>
    <link rel="stylesheet" href="/css/style.css"> 
    <link rel="stylesheet" href="/css/cadastroFundacao.css">
</head>
<body>
<div class="container">
    <h2>Cadastro de Fundação</h2>

    <form method="POST" action="<?= isset($modo) && $modo === 'editar' ? '/fundacao/update' : '/fundacao/save' ?>">
    <label>Nome da Fundação:</label>
    <input type="text" name="nome" required value="<?= htmlspecialchars($dados['nome'] ?? '') ?>">

    <label>CNPJ:</label>
    <input type="text" name="cnpj" required value="<?= htmlspecialchars($dados['cnpj'] ?? '') ?>" 
           <?= isset($modo) && $modo === 'editar' ? 'readonly' : '' ?>>

    <label>E-mail:</label>
    <input type="text" name="email" required value="<?= htmlspecialchars($dados['email'] ?? '') ?>">

    <label>Telefone:</label>
    <input type="text" name="telefone" required value="<?= htmlspecialchars($dados['telefone'] ?? '') ?>">

    <label>Instituição Associada:</label>
    <input type="text" name="instituicao" required value="<?= htmlspecialchars($dados['instituicao'] ?? '') ?>">

    <div>
        <button type="submit" class="btn-cadastrar">
            <?= isset($modo) && $modo === 'editar' ? 'Atualizar Fundação' : 'Cadastrar Fundação' ?>
        </button>
        <button type="reset" class="btn-limpar">Limpar</button>
    </div>
</form>
</div>

<?php if (!empty($mensagem)): ?>
<div id="popup" class="modal <?= $tipo ?>">
    <div class="modal-content">
        <?= htmlspecialchars($mensagem) ?>
    </div>
</div>
<script>
const popup = document.getElementById('popup');
popup.style.display = 'flex';

<?php if ($tipo === 'success'): ?>
setTimeout(() => {
    popup.style.transition = 'opacity 0.5s';
    popup.style.opacity = '0';
    setTimeout(() => { 
        window.location.href = '/'; 
    }, 500);
}, 1000);
<?php else: ?>
setTimeout(() => {
    popup.style.transition = 'opacity 0.5s';
    popup.style.opacity = '0';
    setTimeout(() => { popup.style.display = 'none'; popup.style.opacity='1'; }, 500);
}, 2000);
<?php endif; ?>
</script>
<?php endif; ?>

</body>
</html>
