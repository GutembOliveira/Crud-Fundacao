<?php
spl_autoload_register(function ($class) {
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    $file = __DIR__ . '/../' . $classPath;

    if (file_exists($file)) {
        require $file;
    } else {
        die("Classe não encontrada. Caminho esperado: $file");
    }
});
