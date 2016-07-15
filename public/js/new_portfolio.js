$(function() {

  var totalPortfolioValue = 0;
  var startingCapital = 1000000;

  var portfolioTableData = $('.new-portfolio-data tbody');
  portfolioTableData.children().each(function(idx,row) {
    calculateTotalShareValue(row);
  });

  calculatePctOfTotal();

  $('span.equity-holdings').text("$"+ Math.floor(totalPortfolioValue).toLocaleString());
  $('span.cash-holdings').text("$" + Math.floor(startingCapital - totalPortfolioValue).toLocaleString());


  var previousValue;
  $('.new-portfolio-data tbody')
    .on('change','.number-of-shares > input', function() {
      var stockRow = $(this).parent().parent();
      calculateTotalShareValue(stockRow);
      calculatePctOfTotal();
      $('span.equity-holdings').text("$"+ Math.floor(totalPortfolioValue).toLocaleString());
      $('span.cash-holdings').text("$" + Math.floor(startingCapital - totalPortfolioValue).toLocaleString());
    })




  // prevents scrolling parent div when scrolled at the end of .new-portfolio-data
  var newPortfolio = $('.new-portfolio-data'),
      height = newPortfolio.height(),
      scrollHeight = newPortfolio.get(0).scrollHeight;

  newPortfolio.bind('mousewheel', function(e) {
    if(this.scrollTop > (scrollHeight - height) && ( e.originalEvent.detail > 0 || e.originalEvent.wheelDelta < 0 )) {
      e.preventDefault();
    }
  });


  function calculateTotalShareValue(stockRow) {
    var numberOfShares = $(stockRow).children('td.number-of-shares').children('input').val();
    var sharePrice = $(stockRow).children('td.stock-price').text();
    var totalValue = numberOfShares * sharePrice;
    $(stockRow).children('td.total-value').text(Math.round(totalValue, 2));
    totalPortfolioValue += totalValue;
  }

  function calculatePctOfTotal() {
    portfolioTableData.children().each(function(idx,row) {
      var numberOfShares = $(row).children('td.number-of-shares').children('input').val();
      var sharePrice = $(row).children('td.stock-price').text();
      var totalValue = numberOfShares * sharePrice;
      var pctOfTotal = totalValue / totalPortfolioValue;
      $(row).children('td.pct-of-total').text(Math.round(pctOfTotal * 100, 0) + "%");
    });
  }


});