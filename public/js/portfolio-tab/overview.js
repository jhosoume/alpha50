$(function() {
  $('.portfolio-content').on('click','#test-api', function() {
    var stock = 'AMZN';
    $.ajax({
      url: "/api/stocks/" + stock,
      data: {'request_type': 'quotes'},
      contentType: 'JSON',
      success: function(data) {
        console.log(data);
      }
    })
  })
})