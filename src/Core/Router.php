<?php

namespace TicTacToe\Core;

use AltoRouter;

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
    public function match($requestUrl = null, $requestMethod = null)
    {
        return $this->altoRouter->match($requestUrl, $requestMethod);
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
