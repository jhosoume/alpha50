$(function() {
  $('#trades-tab').on('tabactive', function() {
    var portfolio_id = Number($("#trades-tab").find("div[data-profile-id]").data('profile-id'));
    var preloader = $("#preloader").html();
    $('#portfolio-trades-chart').append(preloader).trigger('preloading');
    $(this).bind('preloading', align());    
    tradesRequest = $.ajax({
      url: "/api/trades",
      method: 'GET',
      data: {'request_type': 'trade_blotter_value', 'portfolio_id': portfolio_id},
      contentType: 'JSON'
    })

    tradesRequest.then(function(data_points) {
      $('#portfolio-trades-chart .preloader-wrapper').remove();
      var chartArray = createChartArray(data_points);
      renderTimeChart(chartArray, $("#portfolio-trades-chart"),'Daily Trading (Cash Flow)', 'Overall Trading Value');
    })
  })
});