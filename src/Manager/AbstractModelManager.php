<?php

namespace TicTacToe\Manager;

use TicTacToe\Model\ModelInterface;
use TicTacToe\Repository\StorageRepositoryInterface;
use TicTacToe\Validator\ValidatorInterface;

abstract class AbstractModelManager
{
    /**
     * @var StorageRepositoryInterface
     */
    protected StorageRepositoryInterface $storageRepository;

    /**
     * @var ValidatorInterface
     */
    protected ValidatorInterface $validator;

    /**
     * GameManager constructor.
     * @param StorageRepositoryInterface $storageRepository
     * @param ValidatorInterface $validator
     */
    public function __construct(StorageRepositoryInterface $storageRepository, ValidatorInterface $validator)
    {
        $this->storageRepository = $storageRepository;
        $this->validator = $validator;
    }

    /**
     * @inheritDoc
     */
    public function find(string $id): ?ModelInterface
    {
        return $this->storageRepository->find($id);
    }

    /**
     * @inheritDoc
     */
    public function findAll(array $criteria = []): ?array
    {
        return $this->storageRepository->findAll();
    }

    /**
     * @inheritDoc
     */
    public function delete(string $id)
    {
        $this->storageRepository->delete($id);
    }

    /**
     * @inheritDoc
     */
    public function save(ModelInterface $data): ModelInterface
    {
        $this->validator->validate($data);

        return $this->storageRepository->save($data);
    }
}
