<?php
use Controller\AppController;
use Core\Database;
use Core\Response;
use Repository\GamesRepository;
use Core\Session;
use Core\Request;
use Core\Router;
use Controller\PingApiController;
use Controller\GamesApiController;
use Core\Cors;


session_start();

require __DIR__ . '/../autoload.php';
$registerRoutes = require __DIR__ . '/../config/routes.php';
$config = require_once __DIR__ . '/../config/db.php';

Cors::handle();

$response = new Response();
$session = new Session();
$request = new Request();

$repository = new GamesRepository(Database::makePdo($config['db']));


$appController = new AppController($response, $repository, $session, $request);
$router = new Router();
$pingApiController = new PingApiController();

$gamesApiController = new GamesApiController($response, $repository, $session, $request);  // Add this instantiation
$registerRoutes($router, $appController, $pingApiController, $gamesApiController);  // Add $gamesApiController as 4th arg
$router->dispatch($request, $response);