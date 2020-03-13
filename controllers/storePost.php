<?php 

require 'vendor/autoload.php';

use Carbon\Carbon;

$db->storePost([
    'name'=>$_POST['name'],
    'content'=>'test',
    'created_at' => Carbon::now(),
]);