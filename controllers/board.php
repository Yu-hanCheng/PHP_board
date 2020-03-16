<?php
require 'core/bootstrap.php';


setcookie("user_name", $_POST['name'], time()+ 60,'/'); 
$board = $db->selectAll('posts');

require 'views/board.view.php';