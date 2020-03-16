<?php

session_start();
require 'core/bootstrap.php';
try {
    if (isset($_POST['post_id'])) {
        $_SESSION['post_id']=$_POST['post_id'];
        $replies = $db->showReplies($_SESSION['post_id']);
    } else {
        $replies = $db->showReplies($_SESSION['post_id']);
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
require 'views/allReplies.view.php';
