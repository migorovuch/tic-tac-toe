<?php


namespace TicTacToe\Model;


/**
 * Interface ModelInterface
 * @package TicTacToe\Model
 */
interface ModelInterface
{
    /**
     * @return string|null
     */
    public function getId(): ?string;

    /**
     * @param string $id
     * @return $this
     */
    public function setId(string $id): self;
}
