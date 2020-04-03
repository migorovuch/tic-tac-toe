<?php

namespace TicTacToe\Model;

/**
 * Interface GameInterface
 * @package TicTacToe\Model
 */
interface GameInterface extends ModelInterface
{
    const STATUS_RUNNING = 'RUNNING';
    const STATUS_X_WON = 'X_WON';
    const STATUS_O_WON = 'O_WON';
    const STATUS_DRAW = 'DRAW';

    const SYMBOL_X = 'X';
    const SYMBOL_O = 'O';
    const SYMBOL_EMPTY = '-';

    /**
     * @return string
     */
    public function getBoard(): string;

    /**
     * @param string $board
     * @return GameInterface
     */
    public function setBoard(string $board): self;

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @param string $status
     * @return GameInterface
     */
    public function setStatus(string $status): self;

    /**
     * @return bool
     */
    public function isEmpty(): bool;
}
