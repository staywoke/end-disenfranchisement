<?php
if (!file_exists('../config.php')) {
  exit('Missing config.php');
}

require '../config.php';

if (!isset($_REQUEST['token']) || md5($_REQUEST['token']) !== LOG_ACCESS_TOKEN) {
  header('HTTP/1.0 403 Forbidden');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IPN Logs</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
    .display-4 {
      margin-top: 20px;
      font-size: 2.5rem;
    }
    </style>
  </head>
  <body>
    <div class="container">
      <h1 class="display-4">IPN Logs</h1>
      <?php
      echo '<div class="list-group">';
      $fileList = glob("*.txt");
      $fileList = array_reverse($fileList, true);
      foreach ($fileList as $filename) {
        echo '<a href="'.$filename.'" class="list-group-item list-group-item-action" target="_blank"><i class="fa fa-file-text-o"></i>&nbsp; '.$filename.'</a>';
      }
      echo "</div>";
      ?>
    </div>
  </body>
</html>
