<?php

namespace TicTacToe\Manager;

use TicTacToe\Core\Http\Response;
use TicTacToe\Core\Service;
use TicTacToe\Model\GameInterface;
use RuntimeException;

/**
 * Class GameManager
 */
class GameManager extends AbstractModelManager implements GameManagerInterface, Service
{
    /**
     * @inheritDoc
     */
    public function move(string $id, GameInterface $newMove): GameInterface
    {
        /** @var GameInterface $game */
        $game = $this->storageRepository->find($id);
        if ($game->getStatus() == GameInterface::STATUS_END) {
            throw new RuntimeException('Game is finished', Response::HTTP_BAD_REQUEST);
        }
        $this->validator->validate($newMove);
        $game = $this->mergeBoards($game, $newMove);
        if ($this->isWinner($game, GameInterface::SYMBOL_X)) {
            $game
                ->setStatus(GameInterface::STATUS_END)
                ->setWinner(GameInterface::SYMBOL_X);
        } else {
            $game = $this->doMove($game);
            if ($this->isWinner($game, GameInterface::SYMBOL_O)) {
                $game
                    ->setStatus(GameInterface::STATUS_END)
                    ->setWinner(GameInterface::SYMBOL_O);
            } elseif (strpos($game->getBoard(), GameInterface::SYMBOL_EMPTY) === false) {
                //END GAME
                $game
                    ->setStatus(GameInterface::STATUS_END)
                    ->setWinner(GameInterface::SYMBOL_EMPTY);
            }
        }
        $game = $this->storageRepository->save($game);

        return $game;
    }

    /**
     * @param GameInterface $one
     * @param GameInterface $two
     * @return GameInterface
     */
    protected function mergeBoards(GameInterface $one, GameInterface $two)
    {
        $boardOne = $one->getBoard();
        $boardTwo = $two->getBoard();
        $fromStart = strspn($boardOne ^ $boardTwo, "\0");
        $fromEnd = strspn(strrev($boardOne) ^ strrev($boardTwo), "\0");

        $oneEnd = strlen($boardOne) - $fromEnd;
        $twoEnd = strlen($boardTwo) - $fromEnd;

        $start = substr($boardTwo, 0, $fromStart);
        $end = substr($boardTwo, $twoEnd);
        $oneDiff = substr($boardOne, $fromStart, $oneEnd - $fromStart);
        $twoDiff = substr($boardTwo, $fromStart, $twoEnd - $fromStart);

        if (strlen($twoDiff) > 1 || strlen($oneDiff) > 1) {
            throw new RuntimeException('Change few character forbidden', Response::HTTP_BAD_REQUEST);
        }
        if ($oneDiff != GameInterface::SYMBOL_EMPTY) {
            throw new RuntimeException('Characters intersection', Response::HTTP_BAD_REQUEST);
        }
        if ($twoDiff != GameInterface::SYMBOL_X) {
            throw new RuntimeException('Wrong character', Response::HTTP_BAD_REQUEST);
        }

        return $one->setBoard($boardTwo);
    }

    /**
     * @param GameInterface $game
     * @return GameInterface
     */
    protected function doMove(GameInterface $game): GameInterface
    {
        $symbolsArray = str_split($game->getBoard());
        $freSpaces = [];
        foreach ($symbolsArray as $key => $val) {
            if ($val === GameInterface::SYMBOL_EMPTY) {
                $freSpaces[] = $key;
            }
        }
        $randSpace = rand(0, (count($freSpaces) - 1));
        $symbolsArray[$freSpaces[$randSpace]] = GameInterface::SYMBOL_O;

        return $game->setBoard(implode('', $symbolsArray));
    }

    /**
     * @param GameInterface $game
     * @param string $symbol
     * @return bool
     */
    protected function isWinner(GameInterface $game, string $symbol): bool
    {
        $size = (int)\sqrt(\strlen($game->getBoard()));
        $symbolsArray = str_split($game->getBoard());
        //Horisontal and vertical check
        for ($i = 0; $i < $size; $i++) {
            $verticalSymbol = $symbolsArray[$i];
            if ($verticalSymbol === $symbol) {
                $winner = true;
                for ($j = 1; $j < $size; $j++) {
                    if ($symbolsArray[($j * $size)] !== $symbol) {
                        $winner = false;
                        break;
                    }
                }
                if ($winner) {
                    return true;
                }
            }
            $horisontalOffset = $i * $size;
            $horisontalSymbol = $symbolsArray[$horisontalOffset];
            if ($horisontalSymbol === $symbol) {
                $winner = true;
                for ($j = $horisontalOffset; $j < ($horisontalOffset + $size); $j++) {
                    if ($symbolsArray[$j] !== $symbol) {
                        $winner = false;
                        break;
                    }
                }
                if ($winner) {
                    return true;
                }
            }
        }
        //Diagonal check
        $upLeftPosition = 0;
        $upRightPosition = $size - 1;
        if (
            ($leftRight = $symbolsArray[$upLeftPosition] === $symbol)
            || ($rightLeft = $symbolsArray[$upRightPosition] === $symbol)
        ) {
            for ($i = 1; $i < $size; $i++) {
                $upLeftPosition += ($size + 1);
                $upRightPosition += ($size - 1);
                if ($symbolsArray[$upLeftPosition] !== $symbol) {
                    $leftRight = false;
                }
                if ($symbolsArray[$upRightPosition] !== $symbol) {
                    $rightLeft = false;
                }
                if (!$leftRight && !$rightLeft) {
                    break;
                }
            }
            if ($leftRight || $rightLeft) {
                return true;
            }
        }

        return false;
    }
}
