$(function() {
  var stocks = JSON.parse(JSON.stringify($(".stock-bar-data").data('stock-data')));
  var hbsSource = $('#stock-quote-hbs').html();
  var template = Handlebars.compile(hbsSource);


  renderStockBar(stocks);

  function renderStockBar(stocks) {
    $.each(stocks, function(idx, stock) {
      var context = {stock: stock};
      var quoteHtml = template(context);
      $('.stock-quote-area').append(quoteHtml); 
    })
  };
})