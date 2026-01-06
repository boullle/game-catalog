<?php

use Core\Router;
use Controller\AppController;
use Core\Request;
use Core\Response;





return function (Router $router, AppController $controller) {
    $router->get('/', [$controller, 'home']);
    $router->get('/add', [$controller, 'add']);
    $router->get('/games', [$controller, 'games']);
    $router->get('/random', [$controller, 'redirectionRandomGame']);
    $router->post('/add', [$controller, 'handleAddGame']);
    $router->getRegex('#^/games/(\d+)$#', function (Request $req, Response $res, array $m) use ($controller) {
    $controller->gameById((int)$m[1]);
});
};


