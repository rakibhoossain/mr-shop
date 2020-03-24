const Custom = (($) => {
  
$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode      = 'index'
  var intersect = true

  if($('#sales-chart').length){
    var $salesChart = $('#sales-chart')
    var salesChart  = new Chart($salesChart, {
      type   : 'bar',
      data   : {
        labels  : ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
        datasets: [
          {
            backgroundColor: '#007bff',
            borderColor    : '#007bff',
            data           : [1000, 2000, 3000, 2500, 2700, 2500, 3000]
          },
          {
            backgroundColor: '#ced4da',
            borderColor    : '#ced4da',
            data           : [700, 1700, 2700, 2000, 1800, 1500, 2000]
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips           : {
          mode     : mode,
          intersect: intersect
        },
        hover              : {
          mode     : mode,
          intersect: intersect
        },
        legend             : {
          display: false
        },
        scales             : {
          yAxes: [{
            // display: false,
            gridLines: {
              display      : true,
              lineWidth    : '4px',
              color        : 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks    : $.extend({
              beginAtZero: true,

              // Include a dollar sign in the ticks
              callback: function (value, index, values) {
                if (value >= 1000) {
                  value /= 1000
                  value += 'k'
                }
                return '$' + value
              }
            }, ticksStyle)
          }],
          xAxes: [{
            display  : true,
            gridLines: {
              display: false
            },
            ticks    : ticksStyle
          }]
        }
      }
    })
  }



  if($('#visitors-chart').length){
    var $visitorsChart = $('#visitors-chart')
    var visitorsChart  = new Chart($visitorsChart, {
      data   : {
        labels  : ['18th', '20th', '22nd', '24th', '26th', '28th', '30th'],
        datasets: [{
          type                : 'line',
          data                : [100, 120, 170, 167, 180, 177, 160],
          backgroundColor     : 'transparent',
          borderColor         : '#007bff',
          pointBorderColor    : '#007bff',
          pointBackgroundColor: '#007bff',
          fill                : false
          // pointHoverBackgroundColor: '#007bff',
          // pointHoverBorderColor    : '#007bff'
        },
          {
            type                : 'line',
            data                : [60, 80, 70, 67, 80, 77, 100],
            backgroundColor     : 'tansparent',
            borderColor         : '#ced4da',
            pointBorderColor    : '#ced4da',
            pointBackgroundColor: '#ced4da',
            fill                : false
            // pointHoverBackgroundColor: '#ced4da',
            // pointHoverBorderColor    : '#ced4da'
          }]
      },
      options: {
        maintainAspectRatio: false,
        tooltips           : {
          mode     : mode,
          intersect: intersect
        },
        hover              : {
          mode     : mode,
          intersect: intersect
        },
        legend             : {
          display: false
        },
        scales             : {
          yAxes: [{
            // display: false,
            gridLines: {
              display      : true,
              lineWidth    : '4px',
              color        : 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks    : $.extend({
              beginAtZero : true,
              suggestedMax: 200
            }, ticksStyle)
          }],
          xAxes: [{
            display  : true,
            gridLines: {
              display: false
            },
            ticks    : ticksStyle
          }]
        }
      }
    })
  }



  // get current url
  var location = window.location.href;
  // remove active class from all
  $(".nav-sidebar .nav-item").removeClass('active');
  $(".nav-sidebar .nav-item .nav-link").removeClass('active');
  $(".nav-sidebar .has-treeview").removeClass('active');
  // add active class to div that matches active url
  let match_url = $(".nav-sidebar .nav-item a[href='"+location+"']");
  if (match_url.length) {
    $(match_url).removeClass('active').addClass('active');
    $(match_url).parents('.has-treeview').removeClass('menu-open').addClass('menu-open');
    $(match_url).parents('.has-treeview').children('.nav-link').removeClass('active').addClass('active');  
  }

  if($('.textarea.summernote').length){
    $('.textarea.summernote').summernote({
      height: 300
    })
  }
  if($('.select2').length){
    $('.select2').select2({
      theme: 'bootstrap4',
      allowClear: true
    });
  }

  if($('form').length){
    $('form').each(function () {
      if ($(this).data('validator'))
      $(this).data('validator').settings.ignore = ".textarea.summernote *";
    });  
  }



})



})(jQuery)

export default Custom