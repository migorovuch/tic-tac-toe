<?php

return [
    'basePath' => '/api/v1',
    'routes' => [
        [
            'GET',
            '/games',
            'TicTacToe\\Controller\\GameController#games',
            'games'
        ],
        [
            'GET',
            '/games/[guid:id]',
            'TicTacToe\\Controller\\GameController#game',
            'game'
        ],
        [
            'POST',
            '/games',
            'TicTacToe\\Controller\\GameController#create',
            'create_game'
        ],
    ],
    'urlMatchTypes' => [
        'guid' => '\{?[A-Za-z0-9]{8}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{12}\}?'
    ]
];
