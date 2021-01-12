<?php

header("Access-Control-Allow-Orgin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header("Content-Type: application/json");

use TicTacToe\Core\Core;
use TicTacToe\Core\Http\Response;
use TicTacToe\Core\Http\Request;
use TicTacToe\Core\ServiceLocator;
use TicTacToe\Core\Serializer\SerializerInterface;

require dirname(__DIR__).'/vendor/autoload.php';

session_start();

$response = new Response();
$serializer = null;

try {
    /** @var ServiceLocator $serviceLocator */
    $serviceLocator = require_once 'bootstrap.php';
    $serializer = $serviceLocator->get(SerializerInterface::class);

    $request = new Request($_GET, $_POST, $_SERVER, file_get_contents('php://input'));

    $core = new Core($serviceLocator);
    $response = $core->run($request);
} catch (Throwable $exception) {
    $response = new Response(
        ['reason' => $exception->getMessage()],
        empty($exception->getCode()) ? Response::HTTP_INTERNAL_SERVER_ERROR : $exception->getCode()
    );
}
header("HTTP/1.1 {$response->getCode()} {$response->getStatus()}");
foreach ($response->getHeader() as $headerKey => $headerItem) {
    header("{$headerKey}: $headerItem");
}

if ($serializer) {
    echo $serializer->serialize($response->getContent());
}
