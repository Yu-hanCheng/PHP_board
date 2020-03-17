<?php
require 'core/bootstrap.php';

if (isset($_POST['name'])) {
    setcookie("user_name", $_POST['name'], time()+ 60,'/'); 
}
$board = $db->selectAll('posts');

require 'views/board.view.php';