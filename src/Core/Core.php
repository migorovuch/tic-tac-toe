<?php

namespace TicTacToe\Core;

use AltoRouter;
use RuntimeException;
use ReflectionClass;

class Core
{
    /**
     * @var AltoRouter
     */
    protected AltoRouter $router;

    /**
     * @var ServiceLocator
     */
    protected ServiceLocator $serviceLocator;

    /**
     * Router constructor.
     * @param AltoRouter $router
     * @param ServiceLocator $serviceLocator
     */
    public function __construct(AltoRouter $router, ServiceLocator $serviceLocator)
    {
        $this->router = $router;
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     */
    public function run(Request $request): Response
    {
        $url = $request->getServerParam('REQUEST_URI');
        $route = $this->router->match($url);
        if (!$route) {
            throw new RuntimeException(
                Response::REQUEST_STATUS[Response::HTTP_INTERNAL_SERVER_ERROR],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
        [$controllerName, $actionName] = explode('#', $route['target']);
        $controllerReflection = new ReflectionClass($controllerName);
        $controller = $controllerReflection->newInstance();
        $actionReflection = $controllerReflection->getMethod($actionName);
        $params = [];
        foreach ($actionReflection->getParameters() as $reflectionParameter) {
            $param = null;
            if (($parameterClassReflection = $reflectionParameter->getClass())) {
                if($this->serviceLocator->has($parameterClassReflection->getName())) {
                    $param = $this->serviceLocator->get($parameterClassReflection->getName());
                } elseif($parameterClassReflection->getName() == Request::class) {
                    $param = $request;
                }
            } elseif(isset($route['params'][$reflectionParameter->getName()])) {
                $param = $route['params'][$reflectionParameter->getName()];
            }
            $params[] = $param;
        }

        return $actionReflection->invoke($controller, ...$params);
    }
}
