<?php
if (!file_exists('config.php')) {
  exit('Missing config.php');
}

require 'config.php';

if (MAINTENANCE_MODE && !isset($_REQUEST['skip_redirect'])) {
  header("Location: maintenance.php");
  exit();
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

  <head>
    <meta charset="utf-8">
    <title>Restore The Vote</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="We need your help. We can make it possible for 1.6 million more Floridians to vote.">

    <!-- Mobile Specific Meta Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Twitter META Info -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@samswey">
    <meta property="twitter:title" content="Restore The Vote">
    <meta property="twitter:description" content="We need your help. We can make it possible for 1.6 million more Floridians to vote.">
    <meta property="twitter:creator" content="@mrmidi">
    <meta property="twitter:image:src" content="<?= BASE_URL ?>/assets/images/card-image.jpg?v=<?= VERSION_NUMBER ?>">
    <meta property="twitter:domain" content="<?= BASE_URL ?>">

    <!-- Open Graph protocol -->
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Restore The Vote">
    <meta property="og:url" content="<?= BASE_URL ?>">
    <meta property="og:image" content="<?= BASE_URL ?>/assets/images/card-image.jpg?v=<?= VERSION_NUMBER ?>">
    <meta property="og:site_name" content="Restore The Vote">
    <meta property="og:description" content="We need your help. We can make it possible for 1.6 million more Floridians to vote.">

    <!-- Dublin Core Metadata -->
    <meta name="dc:language" content="en_US">
    <meta name="dc:title" content="Restore The Vote">
    <meta name="dc:source" content="<?= BASE_URL ?>">
    <meta name="dc:description" content="We need your help. We can make it possible for 1.6 million more Floridians to vote.">

    <!-- The styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/styles.css?v=<?= VERSION_NUMBER ?>" />

    <link rel="shortcut icon" href="assets/images/favicon.ico?v=<?= VERSION_NUMBER ?>" />
  </head>

  <body>
    <!-- MODAL -->
    <div class="modal-window" id="donate-modal">
      <div class="modal-wrapper">
        <p>Because all petitions need to be signed, returned, processed, and verified by the state by 2/1/18 there is no longer time to mail additional petitions to voters. Sign up to call voters who’ve received petitions in the mail and tell them to sign and return them as soon as possible.</p>
        <p><a href="http://eepurl.com/dgyG3z" target="_blank" class="btn btn-block make-donation">Sign Up</a></p>
      </div>
      <div class="modal-overlay" onclick="closeModal()"></div>
    </div>

    <!--  HEADER -->
    <header class="main-header clearfix">

      <section class="header-wrapper">

        <div class="navbar navbar-default">
          <div class="container">
            <div class="navbar-header">
              <a class="navbar-brand" href="<?= BASE_URL ?>" target="_top">
                <img src="assets/images/logo.png" />
              </a>
            </div>
          </div>
        </div>

      </section>

    </header> <!-- end main-header  -->

    <!-- MAP -->
    <section class="map-widget">
      <div class="map-container">
        <h1>We can give <b>1.6 million people</b> in Florida the ability to vote.</h1>
        <h2><span>GOAL REACHED:</span>&nbsp; The initiative will appear on the Florida ballot this November!</h2>

        <div class="row action-bar">
          <div class="col-xs-12">
            <a href="http://eepurl.com/dgyG3z" title="Sign Petition" target="_blank" class="btn btn-dark help-button">Sign Up to Get Involved</a>
          </div>
        </div>

        <div id="container"></div>

        <div class="status">
          <div class="row stats-headers">
            <div class="col-xs-9">
              <span class="signatures_collected"></span> <i>of <span class="signatures_required"></span></i>
            </div>
            <div class="col-xs-3 text-right">
              <span class="percent_complete"></span>%
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <div class="progress-bar">
                <div class="progress"></div>
              </div>
            </div>
          </div>

          <div class="row stats-subheaders">
            <div class="col-xs-7">
              <div class="blue-dot"></div><span class="petitions_mailed"></span>
            </div>
            <div class="col-xs-5">&nbsp;</div>
          </div>
        </div>

        <h3>&nbsp;</h3>
      </div>
    </section>

    <!-- SIGN UP -->
    <a name="sign-up"></a>
    <section class="cta-section-3">
      <div class="container">
        <div class="row">

          <div class="text-left signup-text">
            <h2>Goal Reached!</h2>
            <p> Enough petition signatures have been submitted to give Florida voters a chance to restore the voting rights of 1.6 million people this November.</p>
            <p>&nbsp;</p>
            <b class="mb">Together, in just one month, we:</b>

            <ul class="mb">
              <li><b>Mailed 133,126 petitions</b> to FL voters</li>
              <li><b>Texted 86,705 FL voters</b> in collaboration with RapidResist</li>
              <li><b>Called 2,052 FL voters</b> through phone banking</li>
            </ul>

            <p>
              <br />Now, it's time to make sure Floridians vote YES on this initiative in November.<br />
            </p>

            <p>
              <a href="http://eepurl.com/dgyG3z" target="_blank" class="btn make-donation" style="color: #FFF">Sign up to help out</a>
            </p>

          </div>
        </div>
      </div>

    </section> <!-- end .cta-section-3  -->

    <!-- ABOUT US -->
    <a name="about-us"></a>
    <section class="cta-section-3 alt-row">
      <div class="container">
        <div class="about-us">
          <p>
            This platform, a project of <a href="http://staywoke.org" target="_blank">StayWoke</a>, was built in partnership with the <a href="https://floridarrc.com/" target="_blank">Florida Rights Restoration Coalition</a> and <a href="https://secondchancesfl.org/" target="_blank">Floridians for a Fair Democracy</a> to collect the petition signatures to put voter rights restoration on the 2018 Florida ballot. With assistance from <a href="https://www.rockthevote.org/" target="_blank">Rock The Vote</a>, we’ve built a crowdsourced system that mails petitions, including prepaid return postage, directly to thousands of registered voters in the state.
          </p>
        </div>
        <div>&nbsp;</div>
        <div class="paid-for-by">
          Pd. pol. adv. paid for and provided in-kind by StayWoke, Inc., P.O. Box 540717, Orlando, FL 32854, and approved by Floridians for a Fair Democracy.
        </div>
      </div>
    </section>

    <!-- FOOTER -->
    <section class="fixed-footer">
      <div class="row social-share">
        <div class="col-sm-12">
          <ul class="share-buttons">
            <li>
              <a href="https://www.facebook.com/sharer/sharer.php?u=<?= rawurlencode(BASE_URL) ?>&quote=<?= rawurlencode(SHARE_MESSAGE) ?>" title="Share on Facebook" target="_blank">
                <i class="fa fa-facebook-square"></i>
              </a>
            </li>
            <li>
              <a href="https://twitter.com/intent/tweet?source=<?= rawurlencode(BASE_URL) ?>&text=<?= rawurlencode(SHARE_MESSAGE) ?>" target="_blank" title="Tweet">
                <i class="fa fa-twitter-square"></i>
              </a>
            </li>
            <li>
              <a href="mailto:?subject=We%20can%20make%20it%20possible%20for%201.6%20million%20more%20Floridians%20to%20vote&body=<?= rawurlencode(SHARE_MESSAGE) ?>" title="Send email">
                <i class="fa fa-envelope-square"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </section>

    <script>
      var COST_PER_MAILER = <?= number_format(COST_PER_MAILER, 2) ?>;
    </script>
    <script src="assets/js/plugins.js?v=<?= VERSION_NUMBER ?>"></script>
    <script src="assets/js/script.js?v=<?= VERSION_NUMBER ?>"></script>
  <?php if (ENABLE_ANALYTICS): ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109823518-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-109823518-1');
    </script>
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '2063073133961763');
      fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=2063073133961763&ev=PageView&noscript=1" /></noscript>
    <!-- End Facebook Pixel Code -->
  <?php endif; ?>

  </body>
</html>
