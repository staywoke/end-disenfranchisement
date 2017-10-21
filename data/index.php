<?php
error_reporting(0);

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

require('functions.php');

exit(get_json());
