<?php

namespace TicTacToe\Repository;

use TicTacToe\Model\Game;
use TicTacToe\Persistence\PersistenceInterface;

class GameRepository extends ModelRepository implements GameRepositoryInterface
{

    /**
     * GameRepository constructor.
     * @param PersistenceInterface $persistence
     */
    public function __construct(PersistenceInterface $persistence)
    {
        parent::__construct($persistence, Game::class);
    }
}
