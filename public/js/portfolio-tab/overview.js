$(function() {

    var stock;
    var quotesRequest;
    var portfolioCash = parseInt($('#portfolio-holdings-chart').data('portfolio-cash'));
    var portfolioEquity = parseInt($('#portfolio-holdings-chart').data('portfolio-equity'));
    var portfolioValue = portfolioCash + portfolioEquity;
    setTimeout(function() {
      stock = 'AMZN';
      quotesRequest = $.ajax({
        url: "/api/stocks/" + stock,
        data: {'request_type': 'quotes'},
        contentType: 'JSON'
      })


      //potentially rewrite this as a named function
      quotesRequest.then(function(data) {
        var chartArray = createChartArray(data);
        renderPortfolioOverviewChart(chartArray, $("#portfolio-overview-chart"));
        renderHoldingsOverviewChart(chartArray, $("#portfolio-holdings-chart"));
      })
    },500)


    var dailyDatePrice = [];
    
    function createChartArray(jsonData) {

      var dailyQuotesArray = jsonData['daily'];
      $.each(dailyQuotesArray,function(idx,quote) {
        dailyDatePrice.push([Date.parse(quote.date),parseInt(quote.close_price)]);
      });

      return dailyDatePrice.sort(function(a, b){return a[0]-b[0]});   

    }

    function renderPortfolioOverviewChart(chartArray, container) {
      container.highcharts('StockChart', {
        rangeSelector : {
          selected : 1
        },
        title : {
          text : 'Portfolio Performance Overview'
        },
        series : [{
          name : stock,
          data : dailyDatePrice,
          tooltip: {
            valueDecimals: 2
          }
        }]
      })
    }

    function renderHoldingsOverviewChart(chartArray, container) {
        container.highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Portfolio Holdings Overview'
            },
            xAxis: {
                labels: {
                  enabled: false
                },
                minorTickLength: 0,
                tickLength: 0,
                categories: ["Portfolio Overview"]
            },
            yAxis: {
                min: 0,
                max: [portfolioValue],
                labels: {
                  enabled: false
                },
                title: {
                  text: null
                }

            },
            legend: {
                reversed: true,
                symbolWidth:50,
                align: 'center'
            },
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
            series: [{
                name: 'Cash',
                data: [portfolioCash],
                pointWidth: 100
            }, {
                name: 'Equity',
                data: [portfolioEquity],
                pointWidth: 100
            }]
        });
    }


















})