<?php

namespace TicTacToe\Manager;

use TicTacToe\Model\ModelInterface;

interface ModelManagerInterface
{
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

    /**
     * @param string $modelName
     */
    public function delete(string $id);

}
