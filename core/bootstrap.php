<?php

require 'core/database/Connection.php';
require 'core/database/QueryBuilder.php';
require 'vendor/autoload.php';

$config = require 'config.php';
$pdo = Connection::make($config);
$db = new QueryBuilder($pdo);
?>