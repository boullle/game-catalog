<?php

use Core\Router;
use Controller\AppController;
use Core\Request;
use Core\Response;
use Controller\PingApiController;
use Controller\GamesApiController;







return function (Router $router, AppController $controller, PingApiController $pingApiController, GamesApiController $gamesApiController): void {
    $router->get('/', [$controller, 'home']);
    $router->get('/add', [$controller, 'add']);
    $router->get('/games', [$controller, 'games']);
    $router->get('/random', [$controller, 'redirectionRandomGame']);
    $router->post('/add', [$controller, 'handleAddGame']);
    $router->getRegex('#^/games/(\d+)$#', function (Request $req, Response $res, array $m) use ($controller) {
        $controller->gameById((int) $m[1]);
    });

    // Routes API
    $router->get('/api/ping', [$pingApiController, 'ping']);
    $router->get('/api/index', [$gamesApiController, 'index']);
    $router->getRegex('#^/api/games/(\d+)$#', function (Request $req, Response $res, array $m) use ($gamesApiController) {
        $gamesApiController->show($req, $res, (int) $m[1]);
    });
    
    $router->getRegex('#^/api/top/(\d+)$#', function (Request $req, Response $res, array $m) use ($gamesApiController) {
        $gamesApiController->bestGames($req, $res, (int) $m[1]);
    });
    $router->getRegex('#^/api/recent/(\d+)$#', function (Request $req, Response $res, array $m) use ($gamesApiController) {
        $gamesApiController->recentGames($req, $res, (int) $m[1]);
    });
    $router->get('/api/ratings', function (Request $req, Response $res) use ($gamesApiController) {
        $gamesApiController->ratingDistribution($req, $res);
    });
    

};


