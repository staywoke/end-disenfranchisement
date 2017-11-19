function trackEvent(category, action, label, value){
  if(typeof ga !== 'undefined'){
    ga('send', 'event', category, action, label, value);
  }

  console.log('send', 'event', category, action, label, value);
}

function printPetition () {
  trackEvent('Navigation', 'Link Clicked', 'Print Petition');
  return confirm('If you\'re currently registered to vote in Florida, print this petition, fill it out, then return it by mail.');
}

function registerToVote () {
  trackEvent('Navigation', 'Link Clicked', 'Register to Vote');
  return confirm('Live in Florida but not yet registered to vote? Register Online.');
}

(function () {
  function smoothScrolling() {

    $(".navbar-nav a, .help-button").on("click", function () {

      if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {

        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        var offset = $('.header-wrapper').outerHeight();

        if (target.length) {
          $('html,body').animate({
            scrollTop: target.offset().top - parseInt(offset, 0)
          }, 500);

          return false;
        }
      }
    });
  }

  function debounce(func, wait, immediate) {
    var timeout;
    return function() {
      var context = this, args = arguments;
      var later = function() {
        timeout = null;
        if (!immediate) func.apply(context, args);
      };
      var callNow = immediate && !timeout;
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
      if (callNow) func.apply(context, args);
    };
  }

  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  function updateDonateText(price) {
    if (price && parseInt(price) > 0) {
      $('#donation-text').html("Donate <b>$" + numberWithCommas(price) + "</b> and we'll mail <b>" + Math.floor(price / COST_PER_MAILER) + "</b> petitions to Florida Registered Voters.");

      $('.selection-group button.donation-choice').each(function(){
        var selectedPrice = $(this).data('price');
        if (parseInt(price) === parseInt(selectedPrice)) {
          $(this).addClass('selected');
        }  else {
          $(this).removeClass('selected');
        }
      });

      trackEvent('Form', 'Data Entry', 'Update Donation', price);

    } else {
      $('#donation-text').html("Donate <b>$" + COST_PER_MAILER + "</b> and we'll mail <b>1</b> petition to Florida Registered Voters.");
      $('.selection-group button.donation-choice').removeClass('selected');
    }
  }

  smoothScrolling();

  $(".modal-overlay").dontScrollParent();

  $('.selection-group button.donation-choice').click(function () {
    $('.selection-group button.donation-choice').removeClass('selected');
    $(this).addClass('selected');

    var price = $(this).data('price');
    $('#amount').val(price);
    updateDonateText(price);

    trackEvent('Form', 'Data Entry', 'Donation Selected', price);
  });

  $('#amount').on('change', function () {
    var price = $(this).val();
    updateDonateText(price);

    trackEvent('Form', 'Data Entry', 'Donation Changed', price);
  });

  $('#amount').on('keyup', function () {
    var price = $(this).val();
    updateDonateText(price);

    trackEvent('Form', 'Data Entry', 'Donation Changed', price);
  });
})();

(function($) {
  "use strict";
  $(document).on('ready', function() {

    $("#signup-form").notifyMe();

    $(window).scroll(debounce(function() {
      if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
        $('.sticky-action-bar').stop().fadeOut(250);
        trackEvent('Navigation', 'Action Bar', 'Hide');
      } else {
        $('.sticky-action-bar').stop().fadeIn(250);
        trackEvent('Navigation', 'Action Bar', 'Show');
      }
    }, 100));
  })
})(jQuery);

var mapData = {
  check: {
    signatures: false,
    mailings: false
  },
  signatures: {},
  mailings: {},
};

$(function() {
  $.getJSON('data/index.php', function( data ) {
    mapData.signatures = data;
    mapData.check.signatures = true;
    renderMap();
  });

  $.getJSON('data/mailings.php', function( data ) {
    mapData.mailings = data;
    mapData.check.mailings = true;
    renderMap();
  });
});

var renderMap = function () {

  if (!mapData.check.signatures || !mapData.check.mailings) {
    return false;
  }

  var deadline = moment("20180201", "YYYYMMDD");
  var today = moment().startOf('day');
  var daysLeft = Math.round(moment.duration(deadline - today).asDays());
  var percentCollected = Math.ceil(mapData.signatures.summary.ballot_percent);

  trackEvent('Map', 'Data Loaded', 'Percent Collected', percentCollected);
  trackEvent('Map', 'Data Loaded', 'Days Left', daysLeft);

  $('.map-container h3').html('<b class="number">' + Math.ceil(percentCollected) + '%</b> of signatures collected. <span><b class="number">' + daysLeft + ' Days</b> left.</span>');

  // Create the chart
  Highcharts.mapChart('container', {
    chart: {
      backgroundColor: 'transparent'
    },
    title: {
      text: '',
      style: {
        display: 'none'
      }
    },
    mapNavigation: {
      enabled: true,
      enableMouseWheelZoom: false,
      buttonOptions: {
        verticalAlign: 'bottom'
      }
    },
    colorAxis: {
      min: 0,
      minColor: '#DDDDDD',
      maxColor: '#0088df'
    },
    plotOptions: {
      map: {
        allAreas: false,
        mapData: Highcharts.maps['countries/us/us-fl-all'],
      }
    },
    series: [
      {
        allAreas: true,
        showInLegend: false
      },
      {
        data: mapData.signatures.map_data,
        name: 'Signatures',
        borderColor: '#f5f5f5',
        states: {
          hover: {
            color: '#0088df'
          }
        }
      },
      {
        type: 'mapbubble',
        name: 'Mailings',
        color: '#0088df',
        data: [
          {
            name: "33701",
            count: 3,
            z: 3,
            lat: 26.8899598,
            lon: -80.8983643
          },
          {
            name: "32003",
            count: 3,
            z: 3,
            lat: 27.7786988,
            lon: -82.794906
          }
        ],
        maxSize: '12%'
      }
    ]
  });
};

var openModal = function () {
  $('#donate-modal').fadeIn();
  trackEvent('Navigation', 'Donation Modal', 'Open');
};

var closeModal = function () {
  $('#donate-modal').fadeOut();
  trackEvent('Navigation', 'Donation Modal', 'Close');
};

var openFacebookModal = function () {
  $('#facebook-modal').fadeIn();
  trackEvent('Navigation', 'Facebook Modal', 'Open');
};

var closeFacebookModal = function () {
  $('#facebook-modal').fadeOut();
  trackEvent('Navigation', 'Facebook Modal', 'Close');
};

var debounce = function(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		var later = function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};
};

(function (e) {
  e.fn.notifyMe = function (t) {
    var form = e(this);

    var email = form.find('input[name=EMAIL]');
    var name = form.find('input[name=NAME]');
    var address = form.find('input[name=ADDRESS]');
    var city = form.find('input[name=CITY]');
    var state = form.find('input[name=STATE]');
    var zipcode = form.find('input[name=ZIPCODE]');
    var hours = form.find('input[name=HOURS]');

    var action = form.attr('action');
    var method = form.attr('method');

    var message = $('.form-message')

    // Reset and hide all messages on .keyup()
    $("#signup-form input, #signup-form textarea").keyup(function () {
      message.fadeOut();
    });

    $("#signup-form select").change(function () {
      message.fadeOut();
    });

    form.on("submit", function (t) {
      var valid = true;
      var error_message = '';

      t.preventDefault();
      var h = email.val();
      var valid_email = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

      if (name.val() === '') {
        valid = false;
        error_message = 'Please Enter your Name';
        name.focus();
      } else if ( !valid_email.test(email.val())) {
        valid = false;
        error_message = 'Please Enter a Valid Email Address';
        email.focus();
      } else if (address.val() === '') {
        valid = false;
        error_message = 'Please Enter your Street Address';
        address.focus();
      } else if (city.val() === '') {
        valid = false;
        error_message = 'Please Enter your City';
        city.focus();
      } else if (state.val() === '') {
        valid = false;
        error_message = 'Please Enter your State';
        state.focus();
      } else if (zipcode.val() === '') {
        valid = false;
        error_message = 'Please Enter your Zip Code';
        zipcode.focus();
      } else if (hours.val() === '') {
        valid = false;
        error_message = 'Please Enter Hours you are Available Per Week';
        hours.focus();
      }

      if (valid) {
        message.removeClass("error bad-email success-full");
        message.hide().text('').fadeIn();

        e.ajax({
          type: method,
          url: action,
          data: e(this).serialize(),
          cache: false,
          dataType: 'json',
          contentType: "application/json; charset=utf-8",
          error: function(err) {
            if (e.status == 404) {
              message.text('Please check your internet connection').fadeIn();
            } else {
              message.text('Please try again later').fadeIn();
            }
            trackEvent('Subscribe', 'AJAX Error', JSON.stringify(err));
          },
          success: function(data) {
            if (data.result !== 'success') {
              message.addClass('error-message').removeClass('success-message');
              message.text(data.msg).fadeIn();

              if(data.msg.indexOf('is already subscribed') > -1){
                trackEvent('Subscribe', 'MailChimp Notice', 'Email Already Subscribed');
              } else {
                trackEvent('Subscribe', 'MailChimp Error', data.msg);
              }
            } else {
              form.trigger( 'reset' );

              message.removeClass('error-message').addClass('success-message');
              message.text('Thanks. We\'ll be in touch.').fadeIn();

              trackEvent('Subscribe', 'MailChimp Success', 'User Subscribed');
            }
          }
        });
      } else {
        message.addClass('error-message').removeClass('success-message');
        message.text(error_message).fadeIn();
      }
    })
  }

})(jQuery);
