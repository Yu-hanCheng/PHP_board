<?php
require 'core/bootstrap.php';


$db = new QueryBuilder($pdo);
$board = $db->selectAll('posts');

require 'views/board.view.php';