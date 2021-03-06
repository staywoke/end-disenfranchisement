function trackEvent(category, action, label, value){
  if(typeof gtag !== 'undefined'){
    gtag('event', action, {
      'event_category': category,
      'event_label': label,
      'value': value
    });
  }
}

function printPetition () {
  trackEvent('Navigation', 'Link Clicked', 'Print Petition');
  return confirm('If you\'re registered to vote in Florida, print this petition, fill it out, then mail it back by 1/15/18 to ensure it’s verified by the deadline.');
}

function registerToVote () {
  trackEvent('Navigation', 'Link Clicked', 'Register to Vote');
  return confirm('Live in Florida but not yet registered to vote? Register Online.');
}

function numberWithCommas(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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

  function updateDonateText(price) {
    if (price && parseInt(price) > 0) {
      $('#donation-text').html("Donate <b>$" + numberWithCommas(price) + "</b> and we'll mail <b>" + Math.floor(price / COST_PER_MAILER) + "</b> petitions with prepaid postage to FL voters.");
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
      $('#donation-text').html("For every <b>$1</b> you donate, we’ll mail <b>4</b> petitions to FL registered voters.");
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

  var $amount = $('#amount');

  $amount.on('change', function () {
    var price = $(this).val();

    if (parseInt(price) < 0) {
      price = Math.abs(price);
      $(this).val(price);
    }

    if (parseInt(price) === 0) {
      price = 1;
      $(this).val(price);
    }

    updateDonateText(price);

    trackEvent('Form', 'Data Entry', 'Donation Changed', price);
  });

  $amount.on('keyup', function () {
    var price = $(this).val();

    if (parseInt(price) < 0) {
      price = Math.abs(price);
      $(this).val(price);
    }

    if (parseInt(price) === 0) {
      price = 1;
      $(this).val(price);
    }

    updateDonateText(price);

    trackEvent('Form', 'Data Entry', 'Donation Changed', price);
  });

  $amount.on('focus', function () {
    $('.donation-choice').attr('disabled', 'disabled');
  });

  $amount.on('blur', function () {
    $('.donation-choice').removeAttr('disabled');
  });
})();

(function($) {
  "use strict";
  $(document).on('ready', function() {

    $('.donation-choice').each(function(){
      var price = $(this).data('price');
      var petitions = Math.floor(price / COST_PER_MAILER);
      $(this).html(petitions + '<span>$' + price + '</span>');
    });

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

  $.getJSON('data/donations.php', function( data ) {
    mapData.donations = data;
    mapData.check.donations = true;
    renderMap();
  });
});

var renderMap = function () {

  if (!mapData.check.signatures || !mapData.check.mailings || !mapData.check.donations) {
    return false;
  }

  var deadline = moment("20180201", "YYYYMMDD");
  var today = moment().startOf('day');
  var daysLeft = Math.round(moment.duration(deadline - today).asDays());
  var percentCollected = Math.ceil(mapData.signatures.summary.ballot_percent);
  var signaturesNeeded = Math.round(mapData.signatures.summary.ballot_needed - mapData.signatures.summary.ballot_total);

  if (signaturesNeeded < 0) {
    signaturesNeeded = 0;
  }

  if (percentCollected > 100) {
    percentCollected = 100;
  }

  $('.signup-text span.signatures_needed').text(numberWithCommas(signaturesNeeded));

  $('.map-widget span.signatures_needed').text(numberWithCommas(signaturesNeeded));
  $('.map-widget span.signatures_collected').text(numberWithCommas(mapData.signatures.summary.ballot_total));
  $('.map-widget span.signatures_required').text(numberWithCommas(mapData.signatures.summary.ballot_needed));
  $('.map-widget span.days_left').text(daysLeft);
  $('.map-widget span.percent_complete').text(percentCollected);
  $('.map-widget .progress').css({ width: percentCollected + '%' });

  trackEvent('Map', 'Data Loaded', 'Percent Collected', percentCollected);
  trackEvent('Map', 'Data Loaded', 'Days Left', daysLeft);

  var mailedPetitions = (mapData.donations.petitions) ? mapData.donations.petitions : mapData.mailings.total;

  if (mailedPetitions < 4000) { // @TODO SET THIS BACK TO 4,000
    $('.blue-dot').hide();
    mapData.mailings.zipcodes = []
  } else {
    var petitions = (mailedPetitions === 1) ? 'Petition' : 'Petitions';
    var petitionText = (mailedPetitions > 0) ? '<b class="number">' + numberWithCommas(mailedPetitions) + '</b> ' + petitions + ' Mailed' : '';

    $('.map-container .petitions_mailed').html(petitionText);
  }

  $('.map-container .petitions_mailed').html('<b class="number">133,126</b> Petitions Mailed');
  $('.map-container').css({ 'opacity': 1 });

  // Create the chart
  Highcharts.mapChart('container', {
    chart: {
      backgroundColor: 'transparent',
      margin: 0,
      zoomType: false
    },
    title: {
      text: '',
      style: {
        display: 'none'
      }
    },
    legend: {
      enabled: false
    },
    mapNavigation: {
      enabled: false
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
        data: mapData.mailings.zipcodes,
        maxSize: 2,
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
