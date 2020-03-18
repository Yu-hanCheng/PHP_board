
<?php 

require 'core/bootstrap.php';

use Carbon\Carbon;
$array = [
    'user_id' => $_COOKIE['user_id'],
    'post_id' => $_POST['post_id'],
    'created_at' => Carbon::now('Asia/Taipei'),
];
if ($_POST['isStore']) {
    $db->storeLike($array);
} else {
    $db->removeLike($array);
}
header('Location:http://localhost:8888/board');