<?php
require_once __DIR__ . '/../services/games.php';
require_once __DIR__ . '/../helpers/debug.php';
final class AppController
{
    public function handleRequest(string $path): void
    {
        if (preg_match('#^/games/(\d+)$#', $path, $m)) {
            $this->gameById((int) $m[1]);
            return;
        }
        switch ($path) {
            case '/':
                //implement logic..
                $this->home();
                break;
            case '/games':
                $this->games();
                break;
            case '/random';
                $this->redirectionRandomGame();
                break;

            default:
                //implement logic..
                $this->notFound();
                break;
        }
    }




    // créer une function render - view (string), data(array)
    private function render(string $view, array $data = [],int $status=200) : void
    {
        http_response_code($status);
        extract($data);

        require __DIR__ . '/../../views/partials/header.php'; //Header
        require __DIR__ . '/../../views/pages/' . $view . '.php';
        require __DIR__ . '/../../views/partials/footer.php';//Footer

    }

    private function home(): void
    {
        // 1.recuperer les jeux. 
        $games = getLimitedGames(3);
        //$featuredGames = array_slice($games, 0, 3);


       
        // 2. Rendre la vue.
        $this->render('home', [
            'featuredGames' => $games,
            'total' => countAll()
        ]);

    }
    private function games(): void
    {
        // 1.recuperer les jeux. 
        $games = getAllSortedByRating();




        
        // 2. Rendre la vue.
        $this->render('games', [
            'games' => $games,
        ]);

    }
    private function gameById(int $id): void
    {

        $game = getGameById($id);

       
        $this->render('detail', [
            'id' => $id,
            'game' => $game
        ]);
    }

    private function redirectionRandomGame(): void
    {
        $game = null;
        $lastId = $_SESSION['last_random_id'];
        for($i=0;$i<5;$i++){
            $candidate=getRandomGame();
            if($candidate['id']!== $lastId){
                $game = $candidate;
            }
        }
        // Sécurité : aucun jeu trouvé
        if (!$game || !isset($game['id'])) {
            header('Location: /');
            exit;
        }
        // Redirection vers l’URL du jeu
        $_SESSION['last_random_id']=$game['id'];
        header('Location: /games/' . $game['id'], true, 302);
        exit;
    }
    private function notFound(): void
    {
        $this->render('not-found',[],404);
    }



}