<?php

namespace TicTacToe\Core;

use AltoRouter;

/**
 * Class Router
 */
class Router implements RouterInterface
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
    public function match($requestUrl = null, $requestMethod = null): array
    {
        return $this->altoRouter->match($requestUrl, $requestMethod);
    }
}
