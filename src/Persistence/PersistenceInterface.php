<?php

namespace TicTacToe\Persistence;

use TicTacToe\Model\ModelInterface;

/**
 * Interface PersistenceInterface
 * @package TicTacToe\Persistence
 */
interface PersistenceInterface
{

    /**
     * @return string
     */
    public function generateId(): string;

    /**
     * @param string $modelName
     * @param ModelInterface $data
     * @return ModelInterface
     */
    public function persist(string $modelName, ModelInterface $data): ModelInterface;

    /**
     * @param string $modelName
     * @param string $id
     * @return ModelInterface
     */
    public function retrieve(string $modelName, string $id): ModelInterface;

    /**
     * @param string $modelName
     * @param array $criteria
     * @return array|null
     */
    public function retrieveBy(string $modelName, array $criteria): ?array;

    /**
     * @param string $modelName
     * @param string $id
     */
    public function delete(string $modelName, string $id);
}
