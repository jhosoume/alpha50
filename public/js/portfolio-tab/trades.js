$(function() {
  setTimeout(function() {
    var portfolio_id = Number($("#trades-tab").find("div[data-profile-id]").data('profile-id'));
    
    tradesRequest = $.ajax({
      url: "/api/trades",
      method: 'GET',
      data: {'request_type': 'trade_blotter_value', 'portfolio_id': portfolio_id},
      contentType: 'JSON'
    })

    tradesRequest.then(function(data_points) {
      var chartArray = createChartArray(data_points);
      renderTradeBlotterChart(chartArray, $("#portfolio-trades-chart"));
    })
  },500)


  var dailyDatePrice = [];
  
  function createChartArray(data_points) {
    $.each(data_points,function(idx,data) {
      dailyDatePrice.push([Date.parse(data.date),parseFloat(data.value)]);
    });
  }

  function renderTradeBlotterChart(chartArray, container) {
    container.highcharts('StockChart', {
      rangeSelector : {
        selected : 1
      },
      title : {
        text : 'Trading Value per Day'
      },
      series : [{
        name : "Overall Trading Value",
        data : dailyDatePrice,
        tooltip: {
          valueDecimals: 2
        }
      }]
    })
  }
});