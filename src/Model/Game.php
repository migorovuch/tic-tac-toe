<?php

namespace TicTacToe\Model;

/**
 * Class Game
 */
class Game implements GameInterface
{
    /**
     * @var string
     */
    protected ?string $id = null;

    /**
     * @var string
     */
    protected string $board;

    /**
     * @var string
     */
    protected string $status = self::STATUS_RUNNING;

    /**
     * @inheritDoc
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getBoard(): string
    {
        return $this->board;
    }

    /**
     * @inheritDoc
     */
    public function setBoard(string $board): self
    {
        $this->board = $board;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @inheritDoc
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isEmpty(): bool
    {
        $board = str_replace(self::SYMBOL_EMPTY, '', $this->board);

        return empty($board);
    }
}
