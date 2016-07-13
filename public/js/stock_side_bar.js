$(function() {

  $('.stock-side-bar').ready(function() {

    var allStocks;

    $.ajax({
      url: '/api/stocks',
      data: {'request_type': 'quotes', 'limit': '50'},
      contentType: 'json',
      success: function (json) {
        allStocks = json['half_hourly'];
        renderStockBar(allStocks);
      }
    });

    var hbsSource = $('#stock-quote-hbs').html();
    var template = Handlebars.compile(hbsSource);
    var timer;


    $('.stock-side-bar')
      .on('keyup', 'input', function() {
        clearQuoteArea();
        var searchTerm = $(this).val();
        if (searchTerm === "") {
          renderStockBar(allStocks);
          return false;
        }
        // ensure that the search term is alphanumeric before creating
        // regex based on the search
        var alphaNum = new RegExp(/^\w+$/);
        if (!alphaNum.test(searchTerm)) return false;

        var re = new RegExp(searchTerm, "i");
        var filtered = allStocks.filter(function(stock) {
          return re.test(stock.ticker) || re.test(stock.name) || re.test(stock.sector);
        });
        window.clearTimeout(timer);
        timer = setTimeout(function() {
          renderStockBar(filtered);
        },400)
      })
      .on('keydown','input',function(e) {
        var searchTerm = $(this).val();
        if (e.which === 8 && searchTerm === "") {
          renderStockBar(allStocks);
          return;
        }
      }) 



    function clearQuoteArea() {
      $(".stock-quote-area").empty();
    }

    function renderStockBar(stocks) {
      $.each(stocks, function(idx, stock) {
        var context = {stock: stock};
        var quoteHtml = template(context);
        $('.stock-quote-area').append(quoteHtml); 
      })
    };    
  })

  return false;

})