$(function() {

  $('#overview-tab').bind('tabactive',function() {
    var quotesRequest;
    var portfolioCash = parseInt($('#portfolio-holdings-chart').data('portfolio-cash'));
    var portfolioEquity = parseInt($('#portfolio-holdings-chart').data('portfolio-equity'));
    var portfolioValue = portfolioCash + portfolioEquity;
    var preloader = $("#preloader").html();
    $('#portfolio-overview-chart').append(preloader).trigger('preloading');
    $(this).bind('preloading', align());    

    valuationsRequest = $.ajax({
      url: "/api" + window.location.pathname,
      method: 'GET',
      data: {'request_type': 'historical_valuation', 'sector':'all'},
      contentType: 'JSON'
    })


    //potentially rewrite this as a named function
    valuationsRequest.then(function(valuations) {
      $("#portfolio-overview-chart .preloader-wrapper").remove();
      var chartArray = createChartArray(valuations);
      renderTimeChart(chartArray, $("#portfolio-overview-chart"), "Portfolio Performance Overview", 'Overall Value');
      renderHoldingsOverviewChart($("#portfolio-holdings-chart"));
    })

    function renderHoldingsOverviewChart(container) {
        container.highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Portfolio Holdings Overview',
                style: {
                  color: "#009688",
                  fontSize: "1.2rem"
                }
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
                align: 'center',
                labelFormatter: function() {
                  var valData = '$'+ this.yData[this.yData.length - 1].toLocaleString();
                  return this.name + " " + valData;
                }
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

})