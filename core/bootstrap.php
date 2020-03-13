<?php

    require 'core/database/Connection.php';
    require 'core/database/QueryBuilder.php';

    $config = require 'config.php';
    $pdo = Connection::make($config);
    return (new QueryBuilder($pdo))->createStatement();
?>