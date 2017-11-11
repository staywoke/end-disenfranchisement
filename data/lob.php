<?php

if (!file_exists('../config.php')) {
  exit('Missing config.php');
}

require '../config.php';
require '../vendor/autoload.php';

$api_key = (LOB_TEST_MODE) ? LOB_TEST_API_KEY : LOB_LIVE_API_KEY;
$lob = new \Lob\Lob($api_key);

$letters = $lob->letters()->all(array(
  'limit'  => 2,
  'offset' => 0
));

echo '<pre>';
var_dump($letters);
echo '</pre>';
