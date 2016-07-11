$(function() {
  var stocks = JSON.parse(JSON.stringify($(".stock-bar-data").data('stock-data')));
  console.log(stocks[0].tic);

})