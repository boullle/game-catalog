<?php

use Core\Router;
use Controller\AppController;
use Core\Request;
use Core\Response;
use Controller\PingApiController;






return function (Router $router, AppController $controller, PingApiController $pingApiController): void {
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
};


