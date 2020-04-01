<?php

namespace TicTacToe\Controller;

use TicTacToe\Core\Request;
use TicTacToe\Core\Response;
use TicTacToe\Core\SerializerInterface;
use TicTacToe\Model\Game;
use TicTacToe\Repository\GameRepositoryInterface;

/**
 * Class GameController
 */
class GameController
{
    /**
     * @param GameRepositoryInterface $gameRepository
     * @return Response
     */
    public function games(GameRepositoryInterface $gameRepository)
    {
        return new Response($gameRepository->findAll());
    }

    /**
     * @param string $id
     * @param GameRepositoryInterface $gameRepository
     * @return Response
     */
    public function game(string $id, GameRepositoryInterface $gameRepository)
    {
        return new Response($gameRepository->find($id));
    }

    /**
     * @param GameRepositoryInterface $gameRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return Response
     */
    public function create(GameRepositoryInterface $gameRepository, SerializerInterface $serializer, Request $request)
    {
        /** @var Game $game */
        $game = $serializer->unserialize(Game::class, $request->getContent());
        $game->setId($gameRepository->generateId());
        $game = $gameRepository->save($game);

        return new Response($game);
    }
}
