<?php
require 'core/bootstrap.php';
use Carbon\Carbon;

session_start();

if ($_POST['type']) {
    $db->storeReply([
    'comment_id' => $_POST['comment_id'],
    'user_id' => $_COOKIE['user_id'],
    'content' => $_POST['content'],
    'created_at' => Carbon::now('Asia/Taipei'),
    ]);
} else {
    $db->storeComment([
        'post_id' => $_POST['post_id'],
        'user_id' => $_SESSION['user_id'],
        'content' => $_POST['content'],
        'created_at' => Carbon::now('Asia/Taipei'),
    ]);
    $_SESSION['post_id'] = $_POST['post_id'];
}
header('Location:http://localhost:8888/showComment');