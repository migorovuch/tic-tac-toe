<?php

namespace TicTacToe\Manager;

use TicTacToe\Model\GameInterface;

/**
 * Interface GameManagerInterface
 * @package TicTacToe\Manager
 */
interface GameManagerInterface extends ModelManagerInterface
{
    /**
     * @param string $id
     * @param GameInterface $newMove
     * @return GameInterface
     */
    public function move(string $id, GameInterface $newMove): GameInterface;
}
