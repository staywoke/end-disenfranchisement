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
    <meta name="description" content="We need your help. We can make it possible for 1.6 million more Floridians - including 1 in 4 black Floridians - to vote during the next Presidential election.">
    <link rel="shortcut icon" href="assets/images/favicon.png" />

    <!-- The styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/styles.css?v=<?= VERSION_NUMBER ?>" />

    <meta property="og:url" content="<?= BASE_URL ?>" />
    <meta property="og:title" content="End Disenfranchisement" />
    <meta property="og:description" content="We need your help. We can make it possible for 1.6 million more Floridians - including 1 in 4 black Floridians - to vote during the next Presidential election." />
    <meta property="og:image" content="<?= BASE_URL ?>/assets/images/card-image.jpg" />

    <meta name="twitter:image" content="<?= BASE_URL ?>/assets/images/card-image.jpg" />
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@samswey">
    <meta name="twitter:domain" content="<?= BASE_URL ?>">
    <meta name="twitter:creator" content="@mrmidi">
  </head>

  <body>

    <div class="modal-window" id="facebook-modal">
      <div class="modal-wrapper">
        <div class="container-fluid selection-group">
          <div class="row">
            <h3 class="modal-title">Share On Facebook</h3>
            <a href="#" onclick="closeFacebookModal(); return false;" class="close-modal">
              <i class="fa fa-times"></i>
            </a>
          </div>

          <p class="instructions">
            Copy the text below to send to your Facebook friends in Florida and ask them to sign this petition.
          </p>

          <textarea>Hey, I’m working to help collect petition signatures for a ballot initiative in Florida that would restore voting rights to 1.6 million people in the state. Help us put this on the Florida ballot by printing this petition, filling it out, and returning it to Floridians for Fair Democracy (the address is on the petition): https://florida.ourstates.org/pdf/petition.pdf</textarea>

          <a href="https://www.facebook.com/search/str/florida/keywords_users" target="_blank" class="btn btn-block make-donation">Get Started</a>

        </div>
      </div>
      <div class="modal-overlay" onclick="closeFacebookModal()"></div>
    </div>

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
              <h3 class="modal-title">How many petitions do you want to mail? &nbsp;<a href="pdf/petition.pdf" title="Sign Petition" target="_blank" onclick="return printPetition()">Already live in Florida?</a></h3>
              <a href="#" onclick="closeModal(); return false;" class="close-modal">
                <i class="fa fa-times"></i>
              </a>
            </div>
            <div class="row">
              <div class="col-sm-3">
                <button type="button" class="btn btn-block donation-choice" data-price="5">6 <span>$5</span></button>
              </div>
              <div class="col-sm-3">
                <button type="button" class="btn btn-block donation-choice" data-price="10">12 <span>$10</span></button>
              </div>
              <div class="col-sm-3">
                <button type="button" class="btn btn-block donation-choice" data-price="20">24 <span>$20</span></button>
              </div>
              <div class="col-sm-3">
                <button type="button" class="btn btn-block donation-choice" data-price="50">60 <span>$50</span></button>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-3">
                <button type="button" class="btn btn-block donation-choice" data-price="100">121 <span>$100</span></button>
              </div>
              <div class="col-sm-3">
                <button type="button" class="btn btn-block donation-choice" data-price="500">609 <span>$500</span></button>
              </div>
              <div class="col-sm-6">
                <div class="input-group mb-2 mb-sm-0">
                  <div class="input-group-addon">$</div>
                  <input type="number" min="5" step="5" onkeypress="return event.charCode >= 48" class="form-control" id="amount" name="amount" placeholder="Enter USD Amount" required="required" autocomplete="false">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-9" id="donation-text">
                Donate <b>$<?= number_format(COST_PER_MAILER, 2) ?></b> and we'll mail <b>1</b> petition to Florida Registered Voters.
              </div>
              <div class="col-sm-3">
                <button type="submit" class="btn btn-block make-donation">Send</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-overlay" onclick="closeModal()"></div>
    </div>

    <!--  HEADER -->

    <!--<header class="main-header transparent-header">-->
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
                  <a href="https://registertovoteflorida.gov" title="Register to Vote" target="_blank" onclick="return registerToVote();">REGISTER TO VOTE</a>
                </li>
                <li>
                  <a href="#sign-up" title="">SIGN UP</a>
                </li>
                <li>
                  <a href="#donate" onclick="openModal(); return false;">DONATE</a>
                </li>
              </ul>
            </div>
          </div>
        </div>

      </section>


    </header> <!-- end main-header  -->

    <!--  HOME SLIDER BLOCK  -->

    <!-- slider start -->
    <section class="map-widget">
      <div class="map-container">
        <h1>We can give 1.6 million people in Florida the right to vote.</h1>
        <h3>&nbsp;</h3>
        <a href="#take-action" class="btn btn-dark btn-block help-button">Take Action</a>
        <div id="container"></div>
      </div>
    </section>
    <!-- slider end -->

    <!--  CTA SECTION  -->

    <a name="sign-up"></a>
    <section class="cta-section-3">

      <div class="container">

        <div class="row">

          <div class="col-md-8 col-sm-12 text-left signup-text">
            <h2>We Need Your Help</h2>
            <p>We can make it possible for 1.6 million more Floridians - including 1 in 4 black Floridians - to vote during the next Presidential election. We need 544,000 more Florida registered voters to sign this petition by February 1st, 2018 to put this voting rights restoration initiative on the ballot.</p>

            <h4>
              <a name="take-action"></a>
              Together, we can make this happen. HERE'S HOW:
            </h4>

            <div class="row">
              <div class="col-md-6">
                <b class="mb">I Live in Florida:</b>

                <ul class="action-list">
                  <li><a href="pdf/petition.pdf" title="Sign Petition" target="_blank" onclick="return printPetition()">Print Petition</a>, fill it out &amp; return it by mail.</li>
                  <li>Not Registered to Vote? <a href="https://registertovoteflorida.gov" title="Register to Vote" target="_blank" onclick="return registerToVote();">Register Online</a>.</li>
                  <li><a href="#" onclick="openFacebookModal(); return false;">Tell Florida Facebook Friends</a> to sign the petition.</li>
                  <li><a href="#donate" onclick="openModal(); return false;">Donate</a> to mail petitions to Florida voters</li>
                </ul>
              </div>

              <div class="col-md-6 ">
                <b class="mb">I Don't Live in Florida:</b>

                <ul class="action-list">
                  <li><a href="#" onclick="openFacebookModal(); return false;">Tell Florida Facebook Friends</a> to sign the petition.</li>
                  <li><a href="#donate" onclick="openModal(); return false;">Donate</a> to mail petitions to Florida voters</li>
                </ul>
              </div>
            </div>

          </div>

          <div class="col-md-4 col-sm-12">
            <form action="https://staywoke.us16.list-manage.com/subscribe/post-json?u=587ee759eff53153f8e9e6e80&amp;id=2713b330f6&c=?" method="post" id="signup-form">
              <div class="row">

                <div class="col-xs-12 input">
                  <input placeholder="Name" type="name" name="NAME" id="mce-NAME">
                </div>

                <div class="col-xs-12 input">
                  <input placeholder="Email Address" type="email" name="EMAIL" id="mce-EMAIL">
                </div>

                <div class="col-xs-12 input">
                  <input placeholder="Street Address" type="text" name="ADDRESS" id="mce-ADDRESS">
                </div>

                <div class="col-xs-12 input">
                  <input placeholder="City" type="text" name="CITY" id="mce-CITY">
                </div>

                <div class="col-xs-12">
                  <div class="col-xs-6 input inset-left">
                    <input placeholder="State" type="text" name="STATE" id="mce-STATE" pattern="[a-zA-Z]{2}" maxlength="2">
                  </div>

                  <div class="col-xs-6 input inset-right">
                    <input placeholder="Zip Code" type="text" name="ZIPCODE" id="mce-ZIPCODE" pattern="[0-9]{5}" maxlength="5">
                  </div>
                </div>

                <div class="col-xs-12 input">
                  <input placeholder="Hours Available Per Week" type="number" name="HOURS" id="mce-HOURS" pattern="[0-9]{5}" maxlength="5">
                </div>

                <div class="col-xs-12 button">
                  <button type="submit" class="btn btn-dark btn-block sign-up">Sign up to Door Knock</button>
                </div>
              </div>

            </form>

            <span class="form-message" style="display: none;"></span>

          </div>
        </div>
      </div>

    </section> <!-- end .cta-section-3  -->

    <section>
      <div class="row social-share">
        <div class="col-sm-12">
          <ul class="share-buttons">
            <li>
              <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(BASE_URL) ?>&t=We%20can%20make%20it%20possible%20for%201.6%20million%20more%20Floridians%20to%20vote%20during%20the%20next%20Presidential%20election." title="Share on Facebook" target="_blank">
                <i class="fa fa-facebook-square"></i>
              </a>
            </li>
            <li>
              <a href="https://twitter.com/intent/tweet?source=<?= urlencode(BASE_URL) ?>&text=We%20can%20make%20it%20possible%20for%201.6%20million%20more%20Floridians%20to%20vote%20during%20the%20next%20Presidential%20election.:%20<?= urlencode(BASE_URL) ?>" target="_blank" title="Tweet">
                <i class="fa fa-twitter-square"></i>
              </a>
            </li>
            <li>
              <a href="mailto:?subject=We%20can%20make%20it%20possible%20for%201.6%20million%20more%20Floridians%20to%20vote%20during%20the%20next%20Presidential%20election.&body=We%20need%20your%20help.%20We%20can%20make%20it%20possible%20for%201.6%20million%20more%20Floridians%20-%20including%201%20in%204%20black%20Floridians%20-%20to%20vote%20during%20the%20next%20Presidential%20election.:%20<?= urlencode(BASE_URL) ?>" target="_blank" title="Send email">
                <i class="fa fa-envelope-square"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </section>

    <div class="sticky-action-bar">
      <div class="row">
        <div class="col-xs-6">
          <a href="#" onclick="openFacebookModal(); return false;">Tell Your Friends</a>
        </div>
        <div class="col-xs-6">
          <a href="#donate" onclick="openModal(); return false;" class="last">Send Petitions</a>
        </div>
      </div>
    </div>

    <script>
      var COST_PER_MAILER = <?= number_format(COST_PER_MAILER, 2) ?>;
    </script>
    <script src="assets/js/plugins.js?v=<?= VERSION_NUMBER ?>"></script>
    <script src="assets/js/script.js?v=<?= VERSION_NUMBER ?>"></script>
  </body>

</html>
