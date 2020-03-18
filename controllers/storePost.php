<?php 

require 'core/bootstrap.php';

use Carbon\Carbon;

Post::create([
    'user_id' => $_COOKIE['user_id'],
    'content' => $_POST['content'],
    'created_at' => Carbon::now('Asia/Taipei'),
]);
header('Location:http://localhost:8888/board');