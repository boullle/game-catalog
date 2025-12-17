<?php

function getAllGames() {
    //1.Path jusqu'aux jeux.
    $path = __DIR__ . '/../../data/game.json';
    //2. Lire Le Fichier.
    $json = file_get_contents($path);
    //3. Recupérer les jeux en tableau.
    if ($json === false) {
        return [];
    }
    $data = json_decode($json, true);
    //4. Retourner les jeux.
    return is_array($data) ? $data : [];
}
function getGameById(int $id):?array {
    foreach (getAllGames() as $gameById) {
        if ((int)($gameById['id']) === $id) { 
            return $gameById;
        }
    }
    return null;
}