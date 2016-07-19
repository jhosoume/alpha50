$(function() {
  $('#trades-tab').on('tabactive', function() {
    var portfolio_id = Number($("#trades-tab").find("div[data-profile-id]").data('profile-id'));
    
    tradesRequest = $.ajax({
      url: "/api/trades",
      method: 'GET',
      data: {'request_type': 'trade_blotter_value', 'portfolio_id': portfolio_id},
      contentType: 'JSON'
    })

    tradesRequest.then(function(data_points) {
      var chartArray = createChartArray(data_points);
      renderTimeChart(chartArray, $("#portfolio-trades-chart"),'Trading Value per Day', 'Overall Trading Value');
    })
  })
});