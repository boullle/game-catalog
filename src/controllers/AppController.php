<?php
require_once __DIR__ . '/../helpers/games.php';
require_once __DIR__ . '/../helpers/debug.php';
final class AppController {
    public function handleRequest(): void {
        $page = $_GET['page'] ?? 'home';

        switch($page) {
            case 'home':
                //implement logic..
                $this->home();
                break;
            case 'games':
                $this->games();
                break;
            case 'detail':
                $this->gameById();
                break;
            default:
                //implement logic..
                $this->notFound();
                break;
        }
    }

    // créer une function render - view (string), data(array)
    private function render(string $view, array $data = []): void {
        extract($data);
       
        require __DIR__ . '/../../views/partials/header.php'; //Header
        require __DIR__ . '/../../views/pages/' . $view . '.php';        
        require __DIR__ . '/../../views/partials/footer.php';//Footer
        
    }   

    private function home(): void {
        // 1.recuperer les jeux. 
        $games = getAllGames(); 
        $featuredGames = array_slice($games, 0, 3);
        

        http_response_code(200);
        // 2. Rendre la vue.
        $this->render('home', [
            'featuredGames' => $featuredGames,
            'total'=> count($games)
        ]);

    }
     private function games(): void {
        // 1.recuperer les jeux. 
        $games = getAllGames();
        usort($games, function($a, $b) {
            return $b['rating'] <=> $a['rating'];
        });

        

        http_response_code(200);
        // 2. Rendre la vue.
        $this->render('games', [
            'games' => $games,
        ]);

    }
    private function gameById(): void {  
        $id = $_GET['id'] ?? null;
        $game = getGameById($id);

        http_response_code(200);
        $this->render('detail', [
            'id' => $id,
            'game' => $game
        ]);
    }
    private function notFound(): void {
        http_response_code(404);
        $this->render('not-found');
    }   



} 