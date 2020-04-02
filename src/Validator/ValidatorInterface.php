<?php

namespace TicTacToe\Validator;

use TicTacToe\Model\ModelInterface;

/**
 * Interface ValidatorInterface
 * @package TicTacToe\Validator
 */
interface ValidatorInterface
{
    /**
     * @param ModelInterface $model
     * @return ModelInterface
     */
    public function validate(ModelInterface $model): ModelInterface;
}
