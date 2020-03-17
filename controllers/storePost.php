<?php 

require 'core/bootstrap.php';

use Carbon\Carbon;

$db->storePost([
    'name' => $_COOKIE['user_name'],
    'content' => $_POST['content'],
    'created_at' => Carbon::now('Asia/Taipei'),
]);
header('Location:http://localhost:8888/board');