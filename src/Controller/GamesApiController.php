<?php
namespace Controller;

use Core\Response;
use Core\Request;
use Repository\GamesRepository;
use Core\Session;


final class GamesApiController
{

    public function __construct(
        private Response $response,
         private GamesRepository $gamesRepository,
         private Session $session,
         private Request $request,
         )
    {
       
    }
     // Méthode pour recuperer tous les jeux les requêtes API liées aux jeux vidéo
     public function index(Request $request, Response $response)
     {
         $games = $this->gamesRepository->findAll();
         $response->json($games);

     }
     // Méthode pour recuperer un jeu par son id
        public function show(Request $request, Response $response, int $id)
        {
            $game = $this->gamesRepository->findById($id);
            if ($game) {
                $response->json($game);
            } else {
                $response->json(['error' => 'Game not found'], 404);
            }
        }
        //Récupérer les meilleurs jeux
        public function bestGames(Request $request, Response $response, int $limit = 3)
        {
            $bestGames = $this->gamesRepository->findTop($limit);

            if ($bestGames) {
                $response->json($bestGames);
            } else {
                $response->json(['error' => 'Game not found'], 404);
            }
        }

        //Récupérer les jeux les plus récents
        public function recentGames(Request $request, Response $response, int $limit = 3)
        {
            $recentGames = $this->gamesRepository->findYounger($limit);

            if ($recentGames) {
                $response->json($recentGames);
            } else {
                $response->json(['error' => 'Game not found'], 404);
            }
        }
        //Distribution des notes
        public function ratingDistribution(Request $request, Response $response)
        {
            $ratingDistribution = $this->gamesRepository->countByRating();

            if ($ratingDistribution) {
                $response->json($ratingDistribution);
            } else {
                $response->json(['error' => 'No data found'], 404);
            }
        }   

     
     

}