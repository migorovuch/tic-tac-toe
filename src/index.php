<?php
header("Access-Control-Allow-Orgin: *");
header("Access-Control-Allow-Methods: *");
header("Content-Type: application/json");

use TicTacToe\Core\Core;
use TicTacToe\Core\Response;
use TicTacToe\Core\Request;
use TicTacToe\Core\ServiceLocator;

require dirname(__DIR__).'/vendor/autoload.php';

$response = new Response();
try {
    $config = require_once 'config.php';
    $router = new AltoRouter($config['routes'], $config['basePath'], $config['urlMatchTypes']);
    $request = new Request($_GET, $_POST, $_SERVER, file_get_contents('php://input'));
    $core = new Core($router, new ServiceLocator());
    $response = $core->run($request);
} catch (Exception $exception) {
    $response = new Response(
        ['error' => $exception->getMessage()],
        $exception->getCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR
    );
}
header("HTTP/1.1 {$response->getCode()} {$response->getStatus()}");

echo json_encode($response->getContent());

