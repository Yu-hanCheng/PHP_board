<?php

require 'core/bootstrap.php';
use Carbon\Carbon;
$replies = $db->showReplies($_POST['post_id']);
require 'views/allReplies.view.php';
