$(function() {
  $('.portfolio-content').on('click','#test-api', function() {
    var stock = 'AMZN';
    var quotesRequest = $.ajax({
      url: "/api/stocks/" + stock,
      data: {'request_type': 'quotes'},
      contentType: 'JSON'
    })

    quotesRequest.then(function(data) {
      console.log(data);
      var dailyQuotes = data[0];
      var datesDailyQuotes = [];
      $.each(dailyQuotes,function(idx,arr) {
        console.log(arr);
      });
      console.log(datesDailyQuotes[0]);
    })
  })
})