<?php

use Core\Router;
use Controller\AppController;




return function (Router $router, AppController $controller) {
    $router->get('/', [$controller, 'home']);
    $router->get('/add', [$controller, 'add']);
    $router->get('/games', [$controller, 'games']);
    $router->get('/random', [$controller, 'redirectionRandomGame']);
    $router->post('/add', [$controller, 'handleAddGame']);
};


