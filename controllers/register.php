<?php

require 'core/bootstrap.php';
use Carbon\Carbon;

if (isset($_POST['name'])) {
    $aUser = $db->storeUser([
        'name' => $_POST['name'],
        'password' => $_POST['password'],
        'created_at' => Carbon::now('Asia/Taipei')
    ]); 
    if (!$aUser) {
        die("please enter another name");
    }
} else {
    die("please enter the user name.");
}

header('Location:http://localhost:8888');