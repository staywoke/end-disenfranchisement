<?php
if (!file_exists('config.php')) {
  exit('Missing config.php');
}

require 'config.php';

$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname='.DB_NAME, DB_USER, DB_PASS);
