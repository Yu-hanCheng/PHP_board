<?php
    $router->define([
        '' => 'controllers/index.php',
        'board' => 'controllers/board.php',
        'storePost' => 'controllers/storePost.php',
        'storeComment' => 'controllers/storeComment.php',
        'showComment' => 'controllers/showComment.php',
        'register' => 'controllers/register.php',
        'storeLike' => 'controllers/storeLike.php',
    ]);