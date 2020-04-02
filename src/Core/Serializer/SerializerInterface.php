<?php

namespace TicTacToe\Core\Serializer;

/**
 * Interface SerializerInterface
 * @package TicTacToe\Core
 */
interface SerializerInterface
{
    /**
     * @param mixed $data
     * @return string
     */
    public function serialize($data): string;

    /**
     * @param string $className
     * @param string $data
     * @return mixed
     */
    public function unserialize(string $data, string $className = null);
}
