<?php
require 'core/bootstrap.php';

if (isset($_POST['name'])) {
    $aUser = $db->isUser($_POST['name'],$_POST['password']); 
    if ($aUser[0]) {
        setcookie("user_id", ($aUser[1])['id'], time()+ 600,'/'); 
        setcookie("user_name", $aUser[1]['name'], time()+ 600,'/'); 
        $board = $db->selectAll('posts');
        require 'views/board.view.php';
    } else {
        echo $aUser[1];
        require 'views/index.view.php';
    }
} elseif (isset($_COOKIE['user_name'])) {
        setcookie("user_id", $_COOKIE['user_id'], time()+ 600,'/'); 
        setcookie("user_name",$_COOKIE['user_name'], time()+ 600,'/'); 
        $board = $db->selectAll('posts');
        require 'views/board.view.php';
} else {
    die("please login first.");
}
