$(function() {

    var stock;
    var quotesRequest;
    var portfolioCash = parseInt($('#portfolio-holdings-chart').data('portfolio-cash'));
    var portfolioEquity = parseInt($('#portfolio-holdings-chart').data('portfolio-equity'));
    var portfolioValue = portfolioCash + portfolioEquity;
    setTimeout(function() {
      quotesRequest = $.ajax({
        url: "/api" + window.location.pathname,
        method: 'GET',
        data: {'request_type': 'historical_valuation', 'sector':'all'},
        contentType: 'JSON'
      })


      //potentially rewrite this as a named function
      quotesRequest.then(function(valuations) {
        var chartArray = createChartArray(valuations);
        renderPortfolioOverviewChart(chartArray, $("#portfolio-overview-chart"));
        renderHoldingsOverviewChart($("#portfolio-holdings-chart"));
        console.log(valuations);
      })
    },500)


    var dailyDatePrice = [];
    
    function createChartArray(valuations) {

      $.each(valuations,function(idx,valuation) {
        dailyDatePrice.push([Date.parse(valuation[0]),parseInt(valuation[1])]);
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

    function renderHoldingsOverviewChart(container) {
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