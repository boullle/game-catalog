<?php
namespace Core;

final class Response {

    public function render(string $view, array $data = [], int $status = 200): void
    {
        http_response_code($status);
        extract($data);

        require __DIR__ . '/../../views/partials/header.php'; //Header
        require __DIR__ . '/../../views/pages/' . $view . '.php';
        require __DIR__ . '/../../views/partials/footer.php';//Footer

    }

    public function redirect(string $to, int $status = 302): void
    {
       header('Location: ' . $to, true, $status);
       exit;
    }
    public function json(mixed $data, int $status = 200):void {
        // définir code http de la réponse
        http_response_code($status);

        //Spécifier que le contenu est du json
        header('Content-Type: application/json; charset=utf-8');

        //convertir des données en json
        echo json_encode($data);

    }


}