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
     * @return ServiceLocator
     */
    public function addInstance(string $class, Service $service): self
    {
        $this->instantiated[$class] = $service;

        return $this;
    }

    /**
     * @param string $class
     * @param array $params
     * @return ServiceLocator
     */
    public function addClass(string $class, array $params): self
    {
        $this->services[$class] = $params;

        return $this;
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
