<?php

require 'core/database/Connection.php';
require 'core/database/QueryBuilder.php';
require 'vendor/autoload.php';

$config = require 'dbconfig.php';
$pdo = Connection::make($config);
$db = new QueryBuilder($pdo);
?>