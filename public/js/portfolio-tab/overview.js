$(function() {
  $('.portfolio-content').on('click','#test-api', function() {
    var stock = 'AMZN';
    var quotesRequest = $.ajax({
      url: "/api/stocks/" + stock,
      data: {'request_type': 'quotes'},
      contentType: 'JSON'
    })

    var dailyDatePrice = [];


    //potentially rewrite this as a named function
    quotesRequest.then(function(data) {
      var dailyQuotesArray = data[0];
      $.each(dailyQuotesArray,function(idx,quote) {
        dailyDatePrice.push([Date.parse(quote.date),parseInt(quote.close_price)]);
      });

      dailyDatePrice.sort(function(a, b){return a[0]-b[0]});

      $("#portfolio-overview-chart").highcharts('StockChart', {
        rangeSelector : {
          selected : 1
        },
        title : {
          text : 'HI'
        },
        series : [{
          name : stock,
          data : dailyDatePrice,
          tooltip: {
            valueDecimals: 2
          }
        }]
      })
    })


  })
})