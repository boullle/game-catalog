<?php
use Controller\AppController;
use Core\Database;
use Core\Response;
use Repository\GamesRepository;
use Core\Session;
use Core\Request;
use Core\Router;
session_start();

require __DIR__ . '/../autoload.php';
$registerRoutes = require __DIR__ . '/../config/routes.php';
$config = require_once __DIR__ . '/../config/db.php';

$path=$_SERVER['REQUEST_URI'];
$response = new Response();
$session = new Session();
$request = new Request();

$repository = new GamesRepository(Database::makePdo($config['db']));


$appController = new AppController($response, $repository, $session, $request);
$router = new Router();
$registerRoutes($router, $appController);
$router->dispatch($request, $response);