<?php

namespace TicTacToe\Validator;

use TicTacToe\Core\Http\Response;
use TicTacToe\Core\Service;
use TicTacToe\Model\GameInterface;
use TicTacToe\Model\ModelInterface;
use RuntimeException;

/**
 * Class GameValidator
 */
class GameValidator implements ValidatorInterface, Service
{
    /**
     * @param GameInterface $model
     * @return GameInterface
     */
    public function validate(ModelInterface $model): ModelInterface
    {
        $size = \sqrt(\strlen($model->getBoard()));
        if (0 > (intval($size) - $size)) {
            throw new RuntimeException('Board size is not valid', Response::HTTP_BAD_REQUEST);
        }
        $pregResult = preg_match(
            '/^['.GameInterface::SYMBOL_X.GameInterface::SYMBOL_O.GameInterface::SYMBOL_EMPTY.']{'.$size.'}/',
            $model->getBoard()
        );
        if (!$pregResult) {
            throw new RuntimeException('Board contains not valid characters', Response::HTTP_BAD_REQUEST);
        }

        return $model;
    }
}
