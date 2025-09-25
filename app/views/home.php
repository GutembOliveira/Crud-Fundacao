<?php
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Fundações</title>
    <link rel="stylesheet" href="/css/style.css"> 
    <link rel="stylesheet" href="/css/home.css">
</head>
<body>
<div class="container">
    <h2>Fundações de Apoio</h2>

    <div class="table-header">
        <button class="btn-adicionar" onclick="window.location.href='/fundacao/cadastrar'">Adicionar Fundação</button>
        
        <div class="search-container">
            <form method="GET" action="/fundacao/buscar">
                <input type="text" name="cnpj" placeholder="Buscar por CNPJ">
                <button type="submit">Pesquisar</button>
            </form>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>CNPJ</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Instituição Associada</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($fundacoes)): ?>
                <?php foreach ($fundacoes as $fundacao): ?>
                    <tr>
                        <td><?= htmlspecialchars($fundacao['nome']) ?></td>
                          <td>
                            <?php
                                $cnpj = preg_replace('/\D/', '', $fundacao['cnpj']); // só números
                                if (strlen($cnpj) === 14) {
                                    echo substr($cnpj, 0, 2) . '.' .
                                        substr($cnpj, 2, 3) . '.' .
                                        substr($cnpj, 5, 3) . '/' .
                                        substr($cnpj, 8, 4) . '-' .
                                        substr($cnpj, 12, 2);
                                } else {
                                    echo htmlspecialchars($fundacao['cnpj']);
                                }
                            ?>
                        </td>
                        <td><?= htmlspecialchars($fundacao['email']) ?></td>
                        <td><?= htmlspecialchars($fundacao['telefone']) ?></td>
                        <td><?= htmlspecialchars($fundacao['instituicao']) ?></td>
                         <td style="display:flex; gap:5px;">
                        <!-- Botão Editar -->
                        <form method="GET" action="/fundacao/editarFundacao" style="display:inline;">
                            <input type="hidden" name="cnpj" value="<?= htmlspecialchars($fundacao['cnpj']) ?>">
                            <button type="submit"
                             style="background-color:#ffc107; color:#fff; border:none; padding:5px 10px; border-radius:4px; cursor:pointer;">
                             Editar
                            </button>
                        </form>

                        <!-- Botão Excluir -->
                        <form method="POST" action="/fundacao/delete"
                              onsubmit="return confirm('Deseja realmente excluir esta fundação?');"
                              style="display:inline;">
                            <input type="hidden" name="cnpj" value="<?= htmlspecialchars($fundacao['cnpj']) ?>">
                            <button type="submit"
                                    style="background-color:#dc3545; color:#fff; border:none; padding:5px 10px; border-radius:4px; cursor:pointer;">
                                Excluir
                            </button>
                        </form>
                    </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center;">Fundação não encontrada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
