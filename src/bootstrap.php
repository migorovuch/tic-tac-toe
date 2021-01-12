<?php

use TicTacToe\Core\ServiceLocator;
use TicTacToe\Persistence\PersistenceInterface;
use TicTacToe\Persistence\SessionPersistence;
use TicTacToe\Repository\GameRepositoryInterface;
use TicTacToe\Repository\GameRepository;
use TicTacToe\Core\Serializer\SerializerInterface;
use TicTacToe\Manager\GameManagerInterface;
use TicTacToe\Manager\GameManager;
use TicTacToe\Validator\GameValidator;
use TicTacToe\Core\Router\RouterInterface;
use TicTacToe\Core\Serializer\JsonSerializer;
use Zumba\JsonSerializer\JsonSerializer as ZumbaJsonSerializer;
use ElisDN\Hydrator\Hydrator;
use TicTacToe\Core\Router\Router;

$config = require_once 'config.php';

$serviceLocator = new ServiceLocator();
$serviceLocator
    ->addInstance(PersistenceInterface::class, new SessionPersistence())
    ->addInstance(
        GameRepositoryInterface::class,
        new GameRepository($serviceLocator->get(PersistenceInterface::class))
    )
    ->addInstance(SerializerInterface::class, new JsonSerializer(new ZumbaJsonSerializer(), new Hydrator()))
    ->addInstance(GameValidator::class, new GameValidator())
    ->addInstance(
        GameManagerInterface::class,
        new GameManager(
            $serviceLocator->get(GameRepositoryInterface::class),
            $serviceLocator->get(GameValidator::class),
        )
    )
    ->addInstance(
        RouterInterface::class,
        new Router(
            new AltoRouter(
                $config['routes'],
                $config['basePath'],
                $config['urlMatchTypes']
            )
        )
    );
