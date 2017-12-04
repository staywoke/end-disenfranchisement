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
    <title>End Disenfranchisement</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="We need your help. We can make it possible for 1.6 million more Floridians to vote.">

    <!-- Mobile Specific Meta Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Twitter META Info -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@samswey">
    <meta property="twitter:title" content="End Disenfranchisement">
    <meta property="twitter:description" content="We need your help. We can make it possible for 1.6 million more Floridians to vote.">
    <meta property="twitter:creator" content="@mrmidi">
    <meta property="twitter:image:src" content="<?= BASE_URL ?>/assets/images/card-image.jpg">
    <meta property="twitter:domain" content="<?= BASE_URL ?>">

    <!-- Open Graph protocol -->
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="End Disenfranchisement">
    <meta property="og:url" content="<?= BASE_URL ?>">
    <meta property="og:image" content="<?= BASE_URL ?>/assets/images/card-image.jpg">
    <meta property="og:site_name" content="End Disenfranchisement">
    <meta property="og:description" content="We need your help. We can make it possible for 1.6 million more Floridians to vote.">

    <!-- Dublin Core Metadata -->
    <meta name="dc:language" content="en_US">
    <meta name="dc:title" content="End Disenfranchisement">
    <meta name="dc:source" content="<?= BASE_URL ?>">
    <meta name="dc:description" content="We need your help. We can make it possible for 1.6 million more Floridians to vote.">

    <!-- The styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/styles.css?v=<?= VERSION_NUMBER ?>" />

    <link rel="shortcut icon" href="assets/images/favicon.png" />
  </head>

  <body>

    <!-- MODAL -->
    <div class="modal-window" id="donate-modal">
      <div class="modal-wrapper">
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
          <input type="hidden" name="cmd" value="_donations">
          <input type="hidden" name="business" value="<?= PAYPAL_BUSINESS_ID ?>">
          <input type="hidden" name="return" value="<?= BASE_URL ?>/success.php">
          <input type="hidden" name="cancel_return" value="<?= BASE_URL ?>">
          <input type="hidden" name="notify_url" value="<?= BASE_URL ?>/ipn.php">
          <input type="hidden" name="lc" value="US">
          <input type="hidden" name="item_name" value="StayWoke">
          <input type="hidden" name="item_number" value="FL">
          <input type="hidden" name="no_note" value="1">
          <input type="hidden" name="no_shipping" value="1">
          <input type="hidden" name="rm" value="1">
          <input type="hidden" name="currency_code" value="USD">
          <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
          <input type="hidden" name="address_override" value="1">

          <div class="container-fluid selection-group">
            <div class="row">
              <h3 class="modal-title">How many petitions do you want to mail?</h3>
              <a href="#" onclick="closeModal(); return false;" class="close-modal">
                <i class="fa fa-times"></i>
              </a>
            </div>
            <div class="row">
              <div class="col-sm-3">
                <button type="button" class="btn btn-block donation-choice" data-price="5"></button>
              </div>
              <div class="col-sm-3">
                <button type="button" class="btn btn-block donation-choice" data-price="10"></button>
              </div>
              <div class="col-sm-3">
                <button type="button" class="btn btn-block donation-choice" data-price="20"></button>
              </div>
              <div class="col-sm-3">
                <button type="button" class="btn btn-block donation-choice" data-price="50"></button>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-3">
                <button type="button" class="btn btn-block donation-choice" data-price="100"></button>
              </div>
              <div class="col-sm-3">
                <button type="button" class="btn btn-block donation-choice" data-price="500"></button>
              </div>
              <div class="col-sm-6">
                <div class="input-group mb-2 mb-sm-0">
                  <div class="input-group-addon">$</div>
                  <input type="number" onkeypress="return event.charCode >= 48" class="form-control" id="amount" name="amount" placeholder="Enter USD Amount" required="required" autocomplete="false">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-9" id="donation-text">
                For every <b>$1</b> you donate, we’ll mail <b>4</b> petitions to FL registered voters.
              </div>
              <div class="col-sm-3">
                <button type="submit" class="btn btn-block make-donation">Send</button>
              </div>
            </div>
            <div class="row live-in-florida">
              <a href="pdf/petition.pdf" title="Sign Petition" target="_blank" onclick="return printPetition()">Already live in Florida?&nbsp; Click here to sign the petition.</a>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-overlay" onclick="closeModal()"></div>
    </div>

    <!--  HEADER -->
    <header class="main-header clearfix">

      <section class="header-wrapper">

        <div class="navbar navbar-default">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="<?= BASE_URL ?>" target="_top">
                <img src="assets/images/logo.png" />
              </a>
            </div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav navbar-right">
                <li>
                  <a href="pdf/petition.pdf" title="Sign Petition" target="_blank" onclick="return printPetition()">SIGN PETITION</a>
                </li>
                <li>
                  <a href="#donate" onclick="openModal(); return false;">DONATE PETITIONS</a>
                </li>
                <li>
                  <a href="#about-us" title="">ABOUT US</a>
                </li>
              </ul>
            </div>
          </div>
        </div>

      </section>

    </header> <!-- end main-header  -->

    <!-- MAP -->
    <section class="map-widget">
      <div class="map-container">
        <h1>We can give <b>1.6 million people</b> in Florida the ability to vote.</h1>
        <h2><span class="signatures_needed"></span> more Floridians need to sign the <a href="pdf/petition.pdf" title="Sign Petition" target="_blank" onclick="return printPetition()">petition</a> in the next <span class="days_left"></span> days.</h1>

        <div class="row action-bar">
          <div class="col-xs-6">
            <a href="pdf/petition.pdf" title="Sign Petition" target="_blank" onclick="return printPetition()" class="btn btn-dark btn-block help-button">Sign Petition</a>
          </div>
          <div class="col-xs-6">
            <a href="#donate" onclick="openModal(); return false;" class="btn btn-dark btn-block help-button">Donate Petitions</a>
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
            <div class="col-xs-5 text-right">
              <span class="days_left"></span> Days Left
            </div>
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

          <div class="col-xs-12 text-left signup-text">
            <h2>We Need Your Help</h2>
            <p>1 in 10 Florida adults is banned from voting because of a past conviction. Florida is one of only three states that permanently takes away their vote. We need <span class="signatures_needed"></span> more Florida registered voters to sign <a href="pdf/petition.pdf" title="Sign Petition" target="_blank" onclick="return printPetition()">this petition</a> by February 1st, 2018 to put an initiative on the ballot that would restore their ability to vote.</p>

            <h4>
              <a name="take-action"></a>
              Together, we can make this happen. HERE'S HOW:
            </h4>

            <div class="row">
              <div class="col-md-6">
                <b class="mb">I Don't Live in Florida:</b>

                <ul class="action-list">
                  <li><a href="#donate" onclick="openModal(); return false;"><b>Send petitions</b> to Florida voters.</a></li>
                  <li>Share the Petition with friends via
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= rawurlencode(BASE_URL) ?>&quote=<?= rawurlencode(SHARE_MESSAGE) ?>" title="Share on Facebook" target="_blank"><b>Facebook</b></a>,
                    <a href="https://twitter.com/intent/tweet?source=<?= rawurlencode(BASE_URL) ?>&text=<?= rawurlencode(SHARE_MESSAGE) ?>" target="_blank" title="Tweet"><b>Twitter</b></a> or
                    <a href="mailto:?subject=We%20can%20make%20it%20possible%20for%201.6%20million%20more%20Floridians%20to%20vote&body=<?= rawurlencode(SHARE_MESSAGE) ?>" title="Send email"><b>Email</b></a>
                  </li>
                </ul>
              </div>

              <div class="col-md-6">
                <b class="mb">I Live in Florida:</b>

                <ul class="action-list">
                  <li><a href="pdf/petition.pdf" title="Sign Petition" target="_blank" onclick="return printPetition()"><b>Print Petition</b>, fill it out &amp; return it by mail.</a></li>
                  <li><a href="https://registertovoteflorida.gov" title="Register to Vote" target="_blank" onclick="return registerToVote();"><b>Not Registered to Vote?</b> Register Online</a>.</li>
                  <li><a href="#donate" onclick="openModal(); return false;"><b>Send petitions</b> to Florida voters.</a></li>
                  <li>Share the Petition with friends via
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= rawurlencode(BASE_URL) ?>&quote=<?= rawurlencode(SHARE_MESSAGE) ?>" title="Share on Facebook" target="_blank"><b>Facebook</b></a>,
                    <a href="https://twitter.com/intent/tweet?source=<?= rawurlencode(BASE_URL) ?>&text=<?= rawurlencode(SHARE_MESSAGE) ?>" target="_blank" title="Tweet"><b>Twitter</b></a> or
                    <a href="mailto:?subject=We%20can%20make%20it%20possible%20for%201.6%20million%20more%20Floridians%20to%20vote&body=<?= rawurlencode(SHARE_MESSAGE) ?>" title="Send email"><b>Email</b></a>
                  </li>
                  <li><a href="https://actionnetwork.org/event_campaigns/voting-restoration-amendment-petition-collection"><b>Attend</b> an event</a></li>
                  <li><a href="https://docs.google.com/forms/d/e/1FAIpQLSdyZSdRDxYncEm5vSnHoNHoqxv3TgIQ8rfxuMAiZxRI6sN13g/viewform"><b>Host</b> an event</a></li>
                </ul>
              </div>
            </div>

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
            This platform, a project of <a href="http://staywoke.org" target="_blank">StayWoke</a>, was built in partnership with the <a href="https://floridarrc.com/" target="_blank">Florida Rights Restoration Coalition</a>, <a href="https://www.rockthevote.org/" target="_blank">Rock The Vote</a>, and the <a href="https://www.aclu.org/" target="_blank">ACLU</a> to collect the petition signatures to put voter rights restoration on the 2018 Florida ballot. Together, we’ve built a crowdsourced system that mails petitions, including prepaid return postage, directly to thousands of registered voters in the state at minimal cost.
          </p>
        </div>

        <div class="our-partners">
          <h3>Our Partners</h3>

          <div class="col-md-3 col-xs-6">
            <a href="https://floridarrc.com" target="_blank">
              <img src="assets/images/frrc.png" />
            </a>
          </div>
          <div class="col-md-3 col-xs-6">
            <a href="https://www.rockthevote.org" target="_blank">
              <img src="assets/images/rtv.png" />
            </a>
          </div>
          <div class="col-md-3 col-xs-6">
            <a href="https://www.floridiansforafairdemocracy.com" target="_blank">
              <img src="assets/images/second-chances.png" />
            </a>
          </div>
          <div class="col-md-3 col-xs-6">
            <a href="https://www.aclu.org" target="_blank">
              <img src="assets/images/aclu.png" />
            </a>
          </div>

          <div>&nbsp;</div>
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
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-109823518-1']);
      _gaq.push(['_trackPageview']);
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
  <?php endif; ?>

  </body>
</html>
