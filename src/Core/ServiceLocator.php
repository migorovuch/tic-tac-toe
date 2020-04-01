<?php

namespace TicTacToe\Core;

use InvalidArgumentException;

/**
 * Class ServiceLocator
 */
class ServiceLocator
{
    /**
     * @var string[][]
     */
    private array $services = [];

    /**
     * @var Service[]
     */
    private array $instantiated = [];

    /**
     * @param string $class
     * @param Service $service
     */
    public function addInstance(string $class, Service $service)
    {
        $this->instantiated[$class] = $service;
    }

    /**
     * @param string $class
     * @param array $params
     */
    public function addClass(string $class, array $params)
    {
        $this->services[$class] = $params;
    }

    /**
     * @param string $interface
     * @return bool
     */
    public function has(string $interface): bool
    {
        return isset($this->services[$interface]) || isset($this->instantiated[$interface]);
    }

    /**
     * @param string $class
     * @return Service
     */
    public function get(string $class): Service
    {
        if (isset($this->instantiated[$class])) {
            return $this->instantiated[$class];
        }
        $args = $this->services[$class];
        $object = new $class(...$args);
        if (!$object instanceof Service) {
            throw new InvalidArgumentException('Could not register service: is no instance of Service');
        }
        $this->instantiated[$class] = $object;

        return $object;
    }
}
