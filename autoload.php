<?php
spl_autoload_register(function ($class) {
    // Notre traitement - namespace->chemin fichier
    $baseDir = __DIR__ . '/src/';
    $file = $baseDir . str_replace('\\', '/', $class) . '.php';
    // verifier si le fichier existe. si oui , on le require
    if (file_exists($file)) {
        require $file;
    }
});
    
