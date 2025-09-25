<?php
require __DIR__ . '/Database.php';
use App\Config\Database;

$pdo = Database::getConnection();

$pdo->exec("
    CREATE TABLE IF NOT EXISTS fundacoes (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        cnpj TEXT NOT NULL UNIQUE,
        email TEXT NOT NULL,
        telefone TEXT NOT NULL,
        instituicao TEXT NOT NULL
    )
");

echo "Tabela fundacoes criada!";
