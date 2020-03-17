<?php

session_start();
require 'core/bootstrap.php';
try {
    if (isset($_POST['post_id'])) {
        $_SESSION['post_id']=$_POST['post_id'];
    }
    $replies = json_decode(json_encode($db->showReplies($_SESSION['post_id'])),true);
} catch (Exception $e) {
    echo $e->getMessage();
}
require 'views/allReplies.view.php';
