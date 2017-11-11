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
  });

  $('#amount').on('change', function () {
    var price = $(this).val();
    updateDonateText(price);
  });

  $('#amount').on('keyup', function () {
    var price = $(this).val();
    updateDonateText(price);
  });
})();

(function($) {
  "use strict";
  $(document).on('ready', function() {

    var $form = $('.signup-form');
    var $email = $('#mce-EMAIL');
    var $phone = $('#mce-MMERGE1');
    var $zipcode = $('#mce-MMERGE2');
    var $alert = $('.form-message');

    $email.on('keyup', function() {
      $alert.removeClass('text-danger text-success').html('').hide();
    });

    if ($form.length > 0) {
      $('button[type="submit"]', $form).on('click', function(event) {
        if (event) {
          event.preventDefault()
        }
        if (validateInput($form)) {
          register($form)
        }
      })
    }

    function validateInput($form) {

      var validEmail = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
      var validZipCode = /^([0-9]{5})$/i;

      $alert.removeClass('text-danger text-success').html('').hide();

      if ($email.val() === '' || !validEmail.test($email.val())) {
        $alert.html('Please Enter a Valid Email Address').addClass('text-danger').fadeIn(500);
        return false;
      }

      if ($zipcode.val() === '' || !validZipCode.test($zipcode.val())) {
        $alert.html('Please Enter a Valid Zipcode').addClass('text-danger').fadeIn(500);
        return false;
      }

      return true;
    }

    function register($form) {
      $.ajax({
        type: $form.attr('method'),
        url: $form.attr('action'),
        data: $form.serialize(),
        cache: false,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        error: function(err) {
          $alert.html(err).addClass('text-danger').fadeIn();
        },
        success: function(data) {
          if (data.result !== 'success') {
            $alert.html(data.msg).addClass('text-danger').fadeIn(500);
          } else {
            $form.trigger('reset');
            $alert.html('Thanks! Check your email to confirm signup.');
            $alert.addClass('text-success').fadeIn(500);

            setTimeout(function(){
              $alert.removeClass('text-danger text-success').html('').hide();
            }, 10000);
          }
        }
      })
    }
  })
})(jQuery);

$(function() {
  $.getJSON('data', function( data ) {

    var daysLeft = moment("20180201", "YYYYMMDD").fromNow(true);
    $('.map-container h3').html('<b class="number">' + Math.ceil(data.summary.ballot_percent) + '%</b> of signatures collected. <span><b class="number">' + daysLeft + '</b> left.</span>');

    // Create the chart
    Highcharts.mapChart('container', {
      chart: {
        map: 'countries/us/us-fl-all',
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
      series: [{
        data: data.map_data,
        name: 'Signatures',
        borderColor: '#f5f5f5',
        states: {
          hover: {
            color: '#0088df'
          }
        },
        dataLabels: {
          enabled: false,
          format: '{point.name} '
        }
      }]
    });
  });
});
