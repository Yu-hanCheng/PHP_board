<?php
require 'core/bootstrap.php';
use Carbon\Carbon;

session_start();

if ($_POST['type']) {
    $db->storeReReply([
    'reply_id'=>$_POST['reply_id'],
    'name'=>$_COOKIE['user_name'],
    'content'=>$_POST['content'],
    'created_at' => Carbon::now(),
    ]);
} else {
    $db->storeReply([
        'post_id'=>$_POST['post_id'],
        'name'=>$_COOKIE['user_name'],
        'content'=>$_POST['content'],
        'created_at' => Carbon::now(),
    ]);
}