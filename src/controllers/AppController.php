<?php
require_once __DIR__ . '/../services/games.php';
require_once __DIR__ . '/../helpers/debug.php';
final class AppController {
    public function handleRequest(string $path): void {
        if (preg_match('#^/games/(\d+)$#', $path, $m)) {
        $this->gameById((int)$m[1]);
        return;
        }
        switch($path) {
            case '/':
                //implement logic..
                $this->home();
                break;
            case '/games':
                $this->games();
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
        $games =getLimitedGames(3); 
        //$featuredGames = array_slice($games, 0, 3);
        

        http_response_code(200);
        // 2. Rendre la vue.
        $this->render('home', [
            'featuredGames' => $games,
            'total'=> countAll()
        ]);

    }
     private function games(): void {
        // 1.recuperer les jeux. 
        $games = getAllSortedByRating();
    

        

        http_response_code(200);
        // 2. Rendre la vue.
        $this->render('games', [
            'games' => $games,
        ]);

    }
    private function gameById(int $id): void {  
        
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