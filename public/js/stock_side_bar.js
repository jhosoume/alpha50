$(function() {
  $('.stock-side-bar').ready(function() {
    var allStocks;
    var allDailyQuotes;

    $.ajax({
      url: '/api/stocks',
      data: {'request_type': 'latest_quotes'},
      contentType: 'json',
      success: function (json) {
        allStocks = json;
        renderStockBar(allStocks);

        // After they're rendered, grab the json for spark lines
        $.ajax({
          url: '/api/stocks',
          data: {'request_type': 'daily_quotes', 'limit': 10},
          contentType: 'json',
          success: function (json) {
            allDailyQuotes = json;
            createSparkTemplates(allDailyQuotes);
          }
        });
      }
    });

    var hbsStockSource = $('#stock-quote-hbs').html();
    var stockTemplate = Handlebars.compile(hbsStockSource);
    var hbsSparkSource = $('#stock-spark-hbs').html();
    var sparkTemplate = Handlebars.compile(hbsSparkSource);
    var timer;


    $('.stock-side-bar')
      .on('keyup', 'input', function() {
        $(".stock-quote").removeClass("active");
        var searchTerm = $(this).val();
        if (searchTerm === "") {
          $(".stock-quote").addClass("active");
          return false;
        }
        // ensure that the search term is alphanumeric before creating
        // regex based on the search
        var alphaNum = new RegExp(/^\w+$/);
        if (!alphaNum.test(searchTerm)) return false;

        var re = new RegExp(searchTerm, "i");
        allStocks.forEach(function(stock) {
          if (re.test(stock.ticker) || re.test(stock.name) || re.test(stock.sector)) {
            $('.stock-quote[data-ticker="'+stock.ticker+'"]').addClass('active');
          }
        });

      })

    function renderStockBar(stocks) {
      stocks = stocks.filter(function(n){ return n.latest_price != undefined });
      stocks.sort(function(a, b) {
        return a.ticker > b.ticker;
      });
      
      $.each(stocks, function(idx, stock) {
        var contextStock = {
          ticker: stock.ticker,
          price: stock.latest_price,
          name: stock.name,
        };
        var stockHtml = $(stockTemplate(contextStock));
        stockHtml.appendTo('.stock-quote-area');

        stockHtml.tooltip({delay: 50});
      })
    }

    $(".stock-side-bar").on('mouseenter', '.stock-quote', function() {
      var ticker = $(this).data('ticker');
      var name = $(this).data('name');
      var container = $('#'+$(this).data('tooltip-id')).find('.chart');
      if (container.text() === '') {
        var dataArray = [];

        $.each(allDailyQuotes[ticker], function(idx, quote) {
          var date = new Date(quote.date);
          dataArray.push([Date.UTC(date.getFullYear(), date.getMonth(), date.getDate()), quote.close_price]);
        });

        renderSparkChart(dataArray, container, ticker, name);
      }
    })


    function createSparkTemplates(daily_quotes) {
      $.each(daily_quotes, function(ticker, quotes) {
        var stockHtml = $('.stock-quote[data-ticker="'+ticker+'"]');
        var stockTooltip = $('#'+stockHtml.data('tooltip-id')+' span');
        stockTooltip.html($(sparkTemplate()));
      });
    }

    function renderSparkChart(chartArray, container, ticker, name) {
      container.highcharts('StockChart', {
        rangeSelector: {
          selected: 1,
          inputEnabled: false,
          buttonTheme: {
              visibility: 'hidden'
          },
          labelStyle: {
              visibility: 'hidden'
          }
        },
        plotOptions: {
          area: {
            fillColor: {
              linearGradient: {
                x1: 0,
                y1: 0,
                x2: 0,
                y2: 1
              },
              stops: [
                [0, Highcharts.getOptions().colors[0]],
                [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
              ]
            },
            lineWidth: 1,
            threshold: null,
            borderWidth: 0,
          }
        },
        title : {
          text : ticker
        },
        subtitle : {
          text : name
        },
        scrollbar : {
            enabled : false
        },
        navigator : {
            enabled : false
        },
        series : [{
          type: 'area',
          name: "",
          data : chartArray,
        }]
      })
    }
  })

  return false;
})