<?php

header("Access-Control-Allow-Orgin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header("Content-Type: application/json");

use TicTacToe\Core\Core;
use TicTacToe\Core\Http\Response;
use TicTacToe\Core\Http\Request;
use TicTacToe\Core\ServiceLocator;
use TicTacToe\Core\Router;
use TicTacToe\Persistence\PersistenceInterface;
use TicTacToe\Persistence\SessionPersistence;
use TicTacToe\Core\Serializer\JsonSerializer;
use TicTacToe\Repository\GameRepositoryInterface;
use Zumba\JsonSerializer\JsonSerializer as ZumbaJsonSerializer;
use TicTacToe\Repository\GameRepository;
use TicTacToe\Core\Serializer\SerializerInterface;
use ElisDN\Hydrator\Hydrator;
use TicTacToe\Manager\GameManagerInterface;
use TicTacToe\Manager\GameManager;
use TicTacToe\Validator\GameValidator;

require dirname(__DIR__).'/vendor/autoload.php';

session_start();

$response = new Response();
$serializedData = '';
try {
    $config = require_once 'config.php';
    $altoRouter = new AltoRouter($config['routes'], $config['basePath'], $config['urlMatchTypes']);
    $router = new Router($altoRouter);
    $request = new Request($_GET, $_POST, $_SERVER, file_get_contents('php://input'));

    $serializer = new JsonSerializer(new ZumbaJsonSerializer(), new Hydrator());
    $serviceLocator = new ServiceLocator();
    $serviceLocator
        ->addInstance(PersistenceInterface::class, new SessionPersistence())
        ->addInstance(
            GameRepositoryInterface::class,
            new GameRepository($serviceLocator->get(PersistenceInterface::class))
        )
        ->addInstance(SerializerInterface::class, $serializer)
        ->addInstance(GameValidator::class, new GameValidator())
        ->addInstance(
            GameManagerInterface::class,
            new GameManager(
                $serviceLocator->get(GameRepositoryInterface::class),
                $serviceLocator->get(GameValidator::class),
            )
        );
    $core = new Core($router, $serviceLocator);
    $response = $core->run($request);
    if($response->getContent()) {
        $serializedData = $serializer->serialize($response->getContent());
    }
} catch (Throwable $exception) {
    $response = new Response(
        ['reason' => $exception->getMessage()],
        empty($exception->getCode()) ? Response::HTTP_INTERNAL_SERVER_ERROR : $exception->getCode()
    );
}
header("HTTP/1.1 {$response->getCode()} {$response->getStatus()}");

echo $serializedData;
