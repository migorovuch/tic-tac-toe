<?php

namespace TicTacToe\Controller;

use TicTacToe\Core\Http\Request;
use TicTacToe\Core\Http\Response;
use TicTacToe\Core\Serializer\SerializerInterface;
use TicTacToe\Manager\GameManagerInterface;
use TicTacToe\Model\Game;
use RuntimeException;

/**
 * Class GameController
 */
class GameController
{
    /**
     * @param GameManagerInterface $gameManager
     * @return Response
     */
    public function games(GameManagerInterface $gameManager): Response
    {
        return new Response($gameManager->findAll());
    }

    /**
     * @param string $id
     * @param GameManagerInterface $gameManager
     * @return Response
     */
    public function game(string $id, GameManagerInterface $gameManager): Response
    {
        return new Response($gameManager->find($id));
    }

    /**
     * @param string $id
     * @param GameManagerInterface $gameManager
     * @return Response
     */
    public function delete(string $id, GameManagerInterface $gameManager): Response
    {
        $gameManager->delete($id);

        return new Response();
    }

    /**
     * @param GameManagerInterface $gameManager
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return Response
     */
    public function create(
        GameManagerInterface $gameManager,
        SerializerInterface $serializer,
        Request $request
    ): Response {
        /** @var Game $game */
        $game = $serializer->unserialize($request->getContent(), Game::class);
        if (!$game->isEmpty()) {
            throw new RuntimeException('Board should be empty (---------)', Response::HTTP_BAD_REQUEST);
        }
        $game = $gameManager->save($game);

        return new Response($game);
    }

    /**
     * @param string $id
     * @param GameManagerInterface $gameManager
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return Response
     */
    public function move(
        string $id,
        GameManagerInterface $gameManager,
        SerializerInterface $serializer,
        Request $request
    ): Response {
        $newMove = $serializer->unserialize($request->getContent(), Game::class);
        $game = $gameManager->move($id, $newMove);

        return new Response($game);
    }
}
