<?php
if (!file_exists('config.php')) {
  exit('Missing config.php');
}

require 'config.php';
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

  <head>
    <meta charset="utf-8">
    <title>Under Maintenance</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="We need your help. We can make it possible for 1.6 million more Floridians - including 1 in 4 black Floridians - to vote during the next Presidential election.">

    <link rel="shortcut icon" href="assets/images/favicon.ico" />

    <!-- The styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/styles.css?v=<?= VERSION_NUMBER ?>" />

    <meta property="og:url" content="<?= BASE_URL ?>" />
    <meta property="og:title" content="Restore The Vote" />
    <meta property="og:description" content="We need your help. We can make it possible for 1.6 million more Floridians - including 1 in 4 black Floridians - to vote during the next Presidential election." />
    <meta property="og:image" content="<?= BASE_URL ?>/assets/images/card-image.jpg" />

    <meta name="twitter:image" content="<?= BASE_URL ?>/assets/images/card-image.jpg" />
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@samswey">
    <meta name="twitter:domain" content="<?= BASE_URL ?>">
    <meta name="twitter:creator" content="@mrmidi">

    <style>
    body {
      overflow: hidden;
    }
    .maintenance div.btn-wrapper {
      position: absolute;
      bottom: 0;
      margin: 0 auto;
    }
    </style>
  </head>

  <body>
    <div class="maintenance" style="overflow: hidden;">
      <h1>Under Maintenance</h1>
      <div>We are making some minor changes and will be back online in a few minutes.</div>
      <div class="btn-wrapper">
        <a href="<?= BASE_URL ?>" class="btn btn-dark help-button">Reload</a>
      </div>

    </div>
  </body>
</html>
