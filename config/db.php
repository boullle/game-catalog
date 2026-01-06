<?php
$config =[
    'db' =>[

    'host' => '',
    'port' => null,
    'db' =>'',
    'user' =>'',
    'pass' => '',
    'charset'=>'',
    ]
];

$localDbFile = __DIR__ . '/db.local.php';
// vérifier si le fichier de configuration locale existe
if(is_file($localDbFile)){
    // on override db.php avec les valeurs de db.local.php
    $config['db'] = array_replace($config['db'], (require $localDbFile)['db'] ?? []);
    }
    // retourner la configuration
return $config;

