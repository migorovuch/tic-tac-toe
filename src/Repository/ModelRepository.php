<?php

namespace TicTacToe\Repository;

use TicTacToe\Core\Service;
use TicTacToe\Model\ModelInterface;
use TicTacToe\Persistence\PersistenceInterface;

/**
 * Class ModelRepository
 */
class ModelRepository implements StorageRepositoryInterface, Service
{
    /**
     * @var PersistenceInterface
     */
    protected PersistenceInterface $persistence;

    /**
     * @var string
     */
    protected string $modelName;

    /**
     * GameRepository constructor.
     * @param PersistenceInterface $persistence
     * @param string $modelName
     */
    public function __construct(PersistenceInterface $persistence, string $modelName)
    {
        $this->persistence = $persistence;
        $this->modelName = $modelName;
    }

    /**
     * @return string
     */
    public function generateId(): string
    {
        return $this->persistence->generateId();
    }

    /**
     * @inheritDoc
     */
    public function find(string $id): ?ModelInterface
    {
        return $this->persistence->retrieve($this->modelName, $id);
    }

    /**
     * @param array $criteria
     * @return array|null
     */
    public function findAll(array $criteria = []): ?array
    {
        return $this->persistence->retrieveBy($this->modelName, $criteria);
    }

    /**
     * @inheritDoc
     */
    public function save(ModelInterface $data): ModelInterface
    {
        return $this->persistence->persist($this->modelName, $data);
    }
}
