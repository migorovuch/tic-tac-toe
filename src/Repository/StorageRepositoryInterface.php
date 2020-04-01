<?php

namespace TicTacToe\Repository;

use TicTacToe\Model\ModelInterface;

/**
 * Interface StorageRepositoryInterface
 * @package TicTacToe\Repository
 */
interface StorageRepositoryInterface
{
    /**
     * @return string
     */
    public function generateId(): string;

    /**
     * @param string $id
     * @return ModelInterface|null
     */
    public function find(string $id): ?ModelInterface;

    /**
     * @param array $criteria
     * @return array|null
     */
    public function findAll(array $criteria = []): ?array;

    /**
     * @param ModelInterface $data
     * @return ModelInterface
     */
    public function save(ModelInterface $data): ModelInterface;
}
