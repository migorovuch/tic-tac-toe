<?php

namespace TicTacToe\Persistence;

use TicTacToe\Core\Service;
use TicTacToe\Core\ServiceLocator;
use TicTacToe\Model\ModelInterface;
use OutOfBoundsException;

/**
 * Class SessionPersistence
 */
class SessionPersistence implements PersistenceInterface, Service
{
    /**
     * @inheritDoc
     */
    public function generateId(): string
    {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    /**
     * @inheritDoc
     */
    public function persist(string $modelName, ModelInterface $data): ModelInterface
    {
        return $_SESSION[$modelName][$data->getId()] = $data;
    }

    /**
     * @inheritDoc
     */
    public function retrieve(string $modelName, string $id): ModelInterface
    {
        if (!isset($_SESSION[$modelName][$id])) {
            throw new OutOfBoundsException(sprintf('No data found for ID %d', $id));
        }

        return $_SESSION[$modelName][$id];
    }

    /**
     * @inheritDoc
     */
    public function retrieveBy(string $modelName, array $criteria): ?array
    {
        if (!isset($_SESSION[$modelName])) {
            throw new OutOfBoundsException(sprintf('No data found for %s', $modelName));
        }
        $result = [];
        foreach($_SESSION[$modelName] as $item) {
            $add = true;
            foreach ($criteria as $criteriaName => $criteriaValue) {
                if($item->$criteriaName != $criteriaValue) {
                    $add = false;
                    break;
                }
            }
            if($add) {
                $result[] = $item;
            }
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function delete(string $modelName, string $id)
    {
        if (!isset($_SESSION[$modelName][$id])) {
            throw new OutOfBoundsException(sprintf('No data found for ID %d', $id));
        }
        unset($_SESSION[$modelName][$id]);
    }
}
