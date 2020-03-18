<?php
require 'core/bootstrap.php';

session_start();
if (isset($_POST['name'])) {
    $aUser = $db->isUser($_POST['name'],$_POST['password']); 
    if ($aUser[0]) {
        setcookie("user_id", ($aUser[1])['id'], time()+ 600,'/'); 
        setcookie("user_name", $aUser[1]['name'], time()+ 600,'/');
        $_SESSION['user_id'] = $aUser[1]['id'];
        $board = $db->selectAll('posts', $aUser[1]['id']);
    } else {
        echo $aUser[1]; // return msg
        require 'views/index.view.php';
        return ;
    }
} elseif (isset($_COOKIE['user_name'])) {
    setcookie("user_id", $_COOKIE['user_id'], time()+ 600,'/'); 
    setcookie("user_name",$_COOKIE['user_name'], time()+ 600,'/'); 
    $board = $db->selectAll('posts', $_COOKIE['user_id']);
} else {
    die("please login first.");
}

require 'views/board.view.php';
