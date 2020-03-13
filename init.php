<?php 
require 'core/bootstrap.php';

return (new QueryBuilder($pdo))->createStatement();