<?php
header("Access-Control-Allow-Orgin: *");
header("Access-Control-Allow-Methods: *");
header("Content-Type: application/json");

session_start();

use TicTacToe\Core\Core;
use TicTacToe\Core\Response;
use TicTacToe\Core\Request;
use TicTacToe\Core\ServiceLocator;
use TicTacToe\Core\Router;
use TicTacToe\Persistence\PersistenceInterface;
use TicTacToe\Persistence\SessionPersistence;
use TicTacToe\Core\JsonSerializer;
use TicTacToe\Repository\GameRepositoryInterface;
use Zumba\JsonSerializer\JsonSerializer as ZumbaJsonSerializer;
use TicTacToe\Repository\GameRepository;
use TicTacToe\Core\SerializerInterface;
use ElisDN\Hydrator\Hydrator;

require dirname(__DIR__).'/vendor/autoload.php';

$response = new Response();
$serializer = new JsonSerializer(new ZumbaJsonSerializer(), new Hydrator());
try {
    $config = require_once 'config.php';
    $altoRouter = new AltoRouter($config['routes'], $config['basePath'], $config['urlMatchTypes']);
    $router = new Router($altoRouter);
    $request = new Request($_GET, $_POST, $_SERVER, file_get_contents('php://input'));

    $serviceLocator = new ServiceLocator();
    $serviceLocator
        ->addInstance(PersistenceInterface::class, new SessionPersistence())
        ->addInstance(
            GameRepositoryInterface::class,
            new GameRepository($serviceLocator->get(PersistenceInterface::class))
        )
        ->addInstance(SerializerInterface::class, $serializer);
    $core = new Core($router, $serviceLocator);
    $response = $core->run($request);
} catch (Exception $exception) {
    $response = new Response(
        ['error' => $exception->getMessage()],
        empty($exception->getCode()) ? Response::HTTP_INTERNAL_SERVER_ERROR : $exception->getCode()
    );
}
header("HTTP/1.1 {$response->getCode()} {$response->getStatus()}");

echo $serializer->serialize($response->getContent());

