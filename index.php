ability to vote<?php
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
    <link rel="shortcut icon" href="assets/images/favicon.png" />

    <!-- The styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/styles.css?v=<?= VERSION_NUMBER ?>" />

    <meta property="og:url" content="<?= BASE_URL ?>" />
    <meta property="og:title" content="End Disenfranchisement" />
    <meta property="og:description" content="We need your help. We can make it possible for 1.6 million more Floridians to vote." />
    <meta property="og:image" content="<?= BASE_URL ?>/assets/images/card-image.jpg" />

    <meta name="twitter:image" content="<?= BASE_URL ?>/assets/images/card-image.jpg" />
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@samswey">
    <meta name="twitter:domain" content="<?= BASE_URL ?>">
    <meta name="twitter:creator" content="@mrmidi">
  </head>

  <body>

    <!-- Start Facebook Modal -->
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

          <a href="https://www.facebook.com" target="_blank" class="btn btn-block make-donation">Get Started</a>

        </div>
      </div>
      <div class="modal-overlay" onclick="closeFacebookModal()"></div>
    </div>

    <!-- Start Donate Modal -->
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
                  <input type="number" min="5" step="5" onkeypress="return event.charCode >= 48" class="form-control" id="amount" name="amount" placeholder="Enter USD Amount" required="required" autocomplete="false">
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
                  <a href="https://registertovoteflorida.gov" title="Register to Vote" target="_blank" onclick="return registerToVote();">REGISTER TO VOTE</a>
                </li>
                <li>
                  <a href="#sign-up" title="">SIGN UP</a>
                </li>
                <li>
                  <a href="#about-us" title="">ABOUT US</a>
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

    <!-- MAP -->
    <section class="map-widget">
      <div class="map-container">
        <h1>We can give 1.6 million people in Florida the ability to vote.</h1>
        <h2><span class="signatures_needed"></span> more Floridians need to sign the <a href="pdf/petition.pdf" title="Sign Petition" target="_blank" onclick="return printPetition()">petition</a> in the next <span class="days_left"></span>.</h1>
        <h3>&nbsp;</h3>
        <a href="#take-action" class="btn btn-dark btn-block help-button">Take Action</a>
        <div id="container"></div>
      </div>
    </section>

    <!-- SIGN UP -->
    <a name="sign-up"></a>
    <section class="cta-section-3">
      <div class="container">
        <div class="row">

          <div class="col-md-8 col-sm-12 text-left signup-text">
            <h2>We Need Your Help</h2>
            <p>We can make it possible for 1.6 million more Floridians to vote. We need <span class="signatures_needed"></span> more Florida registered voters to sign this petition by February 1st, 2018 to put this voting rights restoration initiative on the ballot.</p>

            <h4>
              <a name="take-action"></a>
              Together, we can make this happen. HERE'S HOW:
            </h4>

            <div class="row">
              <div class="col-md-6">
                <b class="mb">I Don't Live in Florida:</b>

                <ul class="action-list">
                  <li><a href="#donate" onclick="openModal(); return false;">Send petitions to Florida voters.</a></li>
                  <li><a href="#" onclick="openFacebookModal(); return false;">Tell Florida Facebook Friends to sign the petition.</a></li>
                </ul>
              </div>

              <div class="col-md-6">
                <b class="mb">I Live in Florida:</b>

                <ul class="action-list">
                  <li><a href="pdf/petition.pdf" title="Sign Petition" target="_blank" onclick="return printPetition()">Print Petition, fill it out &amp; return it by mail.</a></li>
                  <li><a href="https://registertovoteflorida.gov" title="Register to Vote" target="_blank" onclick="return registerToVote();">Not Registered to Vote? Register Online</a>.</li>
                  <li><a href="#donate" onclick="openModal(); return false;">Send petitions to Florida voters.</a></li>
                  <li><a href="#" onclick="openFacebookModal(); return false;">Tell Florida Facebook Friends to sign the petition.</a></li>
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
                  <button type="submit" class="btn btn-dark btn-block sign-up">Sign up to Get Involved</button>
                </div>
              </div>

            </form>

            <span class="form-message" style="display: none;"></span>

          </div>
        </div>
      </div>

    </section> <!-- end .cta-section-3  -->

    <!-- ABOUT US -->
    <a name="about-us"></a>
    <section class="cta-section-3 alt-row">
      <div class="container">
        <div class="about-us">
          <p>This platform, a project of <a href="http://staywoke.org" target="_blank">StayWoke</a>, was built in partnership with the <a href="https://floridarrc.com/" target="_blank">Florida Rights Restoration Coalition</a> and other local organizers in Florida to help collect the necessary petition signatures to put voter rights restoration on the 2018 Florida ballot. With assistance from <a href="https://www.rockthevote.org/" target="_blank">Rock The Vote</a> and <a href="https://www.aclu.org/" target="_blank">ACLU</a>, we’ve built a crowdsourced mailing system that will send petitions, including prepaid return postage, directly to thousands of registered voters in the state at minimal cost. Based on the results of this effort, we hope to expand this strategy to help put progressive policies on the ballot in other states as well.</p>
        </div>

        <div class="our-partners">
          <h3>Our Partners</h3>
          <div class="col-md-3">
            <a href="https://www.aclu.org" target="_blank">
              <img src="assets/images/aclu.png" />
            </a>
          </div>
          <div class="col-md-3">
            <a href="https://floridarrc.com" target="_blank">
              <img src="assets/images/frrc.png" />
            </a>
          </div>
          <div class="col-md-3">
            <a href="https://www.rockthevote.org" target="_blank">
              <img src="assets/images/rtv.png" />
            </a>
          </div>
          <div class="col-md-3">
            <a href="https://www.floridiansforafairdemocracy.com" target="_blank">
              <img src="assets/images/second-chances.png" />
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- FOOTER -->
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
        <div class="col-xs-12">
          <a href="#donate" onclick="openModal(); return false;">Send Petitions</a>
        </div>
      </div>
    </div>

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
