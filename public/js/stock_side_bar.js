$(function() {

  $('.stock-side-bar').ready(function() {

    var allStocks = JSON.parse(JSON.stringify($(".stock-bar-data").data('stock-data')));
    var hbsSource = $('#stock-quote-hbs').html();
    var template = Handlebars.compile(hbsSource);
    var timer;


    renderStockBar(allStocks);


    $('.stock-side-bar').on('keyup', 'input', function() {
      clearQuoteArea();
      var searchTerm = $(this).val();
      // ensure that the search term is alphanumeric before creating
      // regex based on the search
      var alphaNum = new RegExp(/^\w+$/);
      if (!alphaNum.test(searchTerm)) return false;

      var re = new RegExp(searchTerm, "i");
      var filtered = allStocks.filter(function(stock) {
        return re.test(stock.tic);
      });
      window.clearTimeout(timer);
      timer = setTimeout(function() {
        renderStockBar(filtered);
      },400)

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