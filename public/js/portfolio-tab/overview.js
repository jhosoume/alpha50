$(function() {
  $('.portfolio-content').on('click','#test-api', function() {
    var stock = 'AMZN';
    var quotesRequest = $.ajax({
      url: "/api/stocks/" + stock,
      data: {'request_type': 'quotes', 'limit': '10'},
      contentType: 'JSON'
    })


    //potentially rewrite this as a named function
    quotesRequest.then(function(data) {
      console.log(data);
      createChart(data);
    })

    function createChart(jsonData) { 
      var chartArray = createChartArray(jsonData);
      renderChart(chartArray, $("#portfolio-overview-chart"));
    }


    var dailyDatePrice = [];
    
    function createChartArray(jsonData) {

      var dailyQuotesArray = jsonData['daily'];
      $.each(dailyQuotesArray,function(idx,quote) {
        dailyDatePrice.push([Date.parse(quote.date),parseInt(quote.close_price)]);
      });

      return dailyDatePrice.sort(function(a, b){return a[0]-b[0]});   

    }

    function renderChart(chartArray, container) {
      container.highcharts('StockChart', {
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
    }


  })
})