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
     * @inheritDoc
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
     * @inheritDoc
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

    /**
     * @inheritDoc
     */
    public function delete(string $id)
    {
        $this->persistence->delete($this->modelName, $id);
    }
}
