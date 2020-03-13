<?php
    $router->define([
        '' => 'controllers/index.php',
        'board' => 'controllers/board.php',
        'storePost' => 'controllers/storePost.php',
        'storeReply' => 'controllers/storeReply.php',
        'showReply' => 'controllers/showReply.php',
    ]);