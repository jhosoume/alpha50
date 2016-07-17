$(function() {


  var totalPortfolioValue = 0;
  var startingCapital = 1000000;

  var portfolioTableData = $('.new-portfolio-data tbody');
  portfolioTableData.children().each(function(idx,row) {
    var totalValue = calculateTotalShareValue(row);
    totalPortfolioValue += totalValue;
  });

  var serializedPortfolioData = {};
  $('.new-portfolio').on('click','button.create-portfolio-btn', function(e) {
    var tradesData = []; 
    portfolioTableData.children('tr').each(function(idx,row) {
     var stock = {
      ticker: $(row).children('td.stock-ticker').text(),
      quantity: $(row).children('td.number-of-shares').children('input').val(),
      price: $(row).children('td.stock-price').text()
     };
     if (stock.quantity > 0) tradesData.push(stock);
    })
    var portfolioInformation = 
      {
      'name': $('#portfolio-name').text(),
      'cash': startingCapital - totalPortfolioValue,
      'value': totalPortfolioValue
      };
    serializedPortfolioData['info'] = portfolioInformation;
    serializedPortfolioData['trades'] = tradesData;

    var form = $('#portfolio-data-form');
    form.children('input').val(JSON.stringify(serializedPortfolioData));
    form.bind('submit', function () {
      $.ajax({
        url:"/portfolios",
        method:'post',
        data:form.serializeArray(),
        success: function(res) {
          console.log(res);
        }
      })
    })


  //   $.ajax({
  //     url: "/api/portfolios",
  //     method: "POST",
  //     data: {'portfolio':JSON.stringify(serializedPortfolioData)},
  //     success: function(data) {
  //       console.log(data);
  //     }
  //   })
  })

  calculatePctOfTotal();

  $('span.equity-holdings').text("$"+ Math.floor(totalPortfolioValue).toLocaleString());
  $('span.cash-holdings').text("$" + Math.floor(startingCapital - totalPortfolioValue).toLocaleString());


  var previousValue;
  $('.new-portfolio-data tbody')
    .on('focus', '.number-of-shares > input', function() {
      previousValue = $(this).val();
    })
    .on('change','.number-of-shares > input', function() {
      var stockRow = $(this).parent().parent();
      calculateTotalShareValue(stockRow);
      var newValue = $(this).val();
      totalPortfolioValue += (newValue - previousValue) * $(this).parent().siblings('td.stock-price').text();
      previousValue = newValue;
      calculatePctOfTotal();
      $('span.equity-holdings').text("$"+ Math.floor(totalPortfolioValue).toLocaleString());
      $('span.cash-holdings').text("$" + Math.floor(startingCapital - totalPortfolioValue).toLocaleString());
    })




  // prevents scrolling parent div when scrolled at the end of .new-portfolio-data
  var newPortfolio = $('.new-portfolio-data');

  newPortfolio.bind('mousewheel', function(e) {
    var height = newPortfolio.height();
    scrollHeight = newPortfolio.get(0).scrollHeight;
    if(this.scrollTop > (scrollHeight - height) && ( e.originalEvent.detail > 0 || e.originalEvent.wheelDelta < 0 )) {
      e.preventDefault();
    }
  });


  function calculateTotalShareValue(stockRow) {
    var numberOfShares = $(stockRow).children('td.number-of-shares').children('input').val();
    var sharePrice = $(stockRow).children('td.stock-price').text();
    var totalValue = numberOfShares * sharePrice;
    $(stockRow).children('td.total-value').text(Math.round(totalValue, 2));
    return totalValue;
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