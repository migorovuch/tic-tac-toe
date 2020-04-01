<?php

namespace TicTacToe\Model;

/**
 * Class Game
 */
class Game implements ModelInterface
{
    const STATUS_RUNNING = 'RUNNING';
    const STATUS_END = 'END';

    /**
     * @var string
     */
    protected string $id;

    /**
     * @var string
     */
    protected string $board;

    /**
     * @var string
     */
    protected string $status = self::STATUS_RUNNING;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Game
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getBoard(): string
    {
        return $this->board;
    }

    /**
     * @param string $board
     * @return Game
     */
    public function setBoard(string $board): self
    {
        $this->board = $board;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Game
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
