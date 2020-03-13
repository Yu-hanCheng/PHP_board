<?php

    require 'core/database/Connection.php';
    require 'core/database/QueryBuilder.php';

    $config = require 'config.php';
    $pdo = Connection::make($config);
?>