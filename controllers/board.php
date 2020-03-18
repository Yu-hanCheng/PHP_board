<?php
require 'core/bootstrap.php';

if (isset($_POST['name'])) {
    $aUser = $db->isUser($_POST['name'],$_POST['password']); 
    if ($aUser[0]) {
        setcookie("user_id", ($aUser[1])['id'], time()+ 600,'/'); 
        setcookie("user_name", $aUser[1]['name'], time()+ 600,'/'); 
    } else {
        echo $aUser[1]; // return msg
        require 'views/index.view.php';
        return ;
    }
} elseif (isset($_COOKIE['user_name'])) {
    setcookie("user_id", $_COOKIE['user_id'], time()+ 600,'/'); 
    setcookie("user_name",$_COOKIE['user_name'], time()+ 600,'/'); 
} else {
    die("please login first.");
}
$board = $db->selectAll('posts', $_COOKIE['user_id']);
require 'views/board.view.php';
