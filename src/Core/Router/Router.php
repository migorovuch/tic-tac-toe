<?php

namespace TicTacToe\Core\Router;

use AltoRouter;
use TicTacToe\Core\Service;

/**
 * Class Router
 */
class Router implements RouterInterface, Service
{
    /**
     * @var AltoRouter
     */
    protected AltoRouter $altoRouter;

    /**
     * Router constructor.
     * @param AltoRouter $altoRouter
     */
    public function __construct(AltoRouter $altoRouter)
    {
        $this->altoRouter = $altoRouter;
    }

    /**
     * @inheritDoc
     */
    public function match($requestUrl = null, $requestMethod = null): ?Route
    {
        $route = null;
        if ($routeParams = $this->altoRouter->match($requestUrl, $requestMethod)) {
            [$controllerName, $actionName] = explode('#', $routeParams['target']);
            $route = new Route($controllerName, $actionName, $routeParams['params'], $routeParams['name']);
        }

        return $route;
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function generate(string $routeName, array $params = []): string
    {
        return $this->altoRouter->generate($routeName, $params);
    }
}
