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
            case '/add':
                $this->add();
                break;

            default:
                //implement logic..
                $this->notFound();
                break;
        }
    }




    // créer une function render - view (string), data(array)
    private function render(string $view, array $data = [], int $status = 200): void
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
        $success = $_SESSION['flash_success'];


        $this->render('detail', [
            'id' => $id,
            'game' => $game,
            'success'  => $success
        ]);
    }

    private function redirectionRandomGame(): void
    {
        $game = null;
        $lastId = $_SESSION['last_random_id'];
        for ($i = 0; $i < 5; $i++) {
            $candidate = getRandomGame();
            if ($candidate['id'] !== $lastId) {
                $game = $candidate;
            }
        }
        // Sécurité : aucun jeu trouvé
        if (!$game || !isset($game['id'])) {
            header('Location: /');
            exit;
        }
        // Redirection vers l’URL du jeu
        $_SESSION['last_random_id'] = $game['id'];
        header('Location: /games/' . $game['id'], true, 302);
        exit;
    }

    private function notFound(): void
    {
        $this->render('not-found', [], 404);
    }
   private function add(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $this->handleAddGame();
        return;
    }

    $this->render('add', []);
}

private function handleAddGame() : void {
    $title = trim($_POST['title']);
    $platform = trim($_POST['platform']);
    $genre = trim($_POST['genre']);
    $releaseYear = (int)($_POST['releaseYear']);
    $rating = (int)($_POST['rating']);
    $description = trim($_POST['description']);
    $notes = trim($_POST['notes']);

    $errors = [];

    if ($title === '') $errors['title'] = 'Title should not be empty';
    if ($platform === '') $errors['platform'] = 'Platform should not be empty';
    if ($genre === '') $errors['genre'] = 'Genre should not be empty';
    if ($rating < 0 || $rating > 10) $errors['rating'] = 'Rating should be between 0 and 10';
    if ($releaseYear < 1800 || $releaseYear > (int)date('Y')) $errors['releaseYear'] = 'Release year should be between 1800 and 2025';
    if ($description === '') $errors['description'] = 'Description should not be empty';
    if ($notes === '') $errors['notes'] = 'Note should not be empty';

    $old = [
        'title' => $title,
        'platform' => $platform,
        'genre' => $genre,
        'releaseYear' => $releaseYear,
        'rating' => $rating,
        'description' => $description,
        'notes' => $notes
    ];

    if (!empty($errors)) {
        $this->render('add', ['old' => $old, 'errors' => $errors], 422);
        return;
    }

    $newGameId = createGame($old);
    $_SESSION['flash_success']='Game added successfully';

    header('Location: /games/' . $newGameId, true, 302);
    exit;
}


}