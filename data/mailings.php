<?php
error_reporting(E_ALL);

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

require('functions.php');

exit(get_mailings_json());
