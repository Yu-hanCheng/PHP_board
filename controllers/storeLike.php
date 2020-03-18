
<?php 

require 'core/bootstrap.php';

use Carbon\Carbon;

$db->storeLike([
    'user_id' => $_COOKIE['user_id'],
    'post_id' => $_POST['post_id'],
    'created_at' => Carbon::now('Asia/Taipei'),
]);
header('Location:http://localhost:8888/board');