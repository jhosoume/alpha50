$(function () {
  $('#analysis-tab')
    .bind('tabactive', function() {
      $('select').material_select();
      var sectorValueRequest = $.ajax({
        url:"/api" + window.location.pathname,
        method: 'GET',
        data: {'request_type':'current_valuation'},
        contentType: 'JSON',
        success: function(res) {
          console.log(res);
          renderSectorOverviewChart($('#sector-breakdown-chart'), res);
        }
      })
      selectSector();
      sectorOverviewChart();
    })
    .on('change','#sector-filter', function () {
      selectSector();
      sectorOverviewChart();
    })

    function sectorOverviewChart() {
        var activeSector = $('#sector-filter').val();
        var preloader = $("#preloader").html();
        $('#portfolio-sector-chart').append(preloader).trigger('preloading');
        var valuationsRequest = $.ajax({
          url: "/api" + window.location.pathname,
          method: 'GET',
          data: {'request_type': 'historical_valuation', 'sector':activeSector},
          contentType: 'JSON'
        });
        valuationsRequest.then(function(valuations) {
          $('#sector-overview-chart .preloader-wrapper').remove();
          var chartArray = createChartArray(valuations);
          renderTimeChart(chartArray, $("#sector-overview-chart"), activeSector+" Performance", 'Overall Sector Value');
        })
    }

    function selectSector() {
      var activeSector = $('#sector-filter').val();
      $('#sector-trades-table').children('tbody').children('tr').each(function(idx,row) {
        var stockSector = $(row).children('td.stock-name').data('sector');
        // console.log(stockSector);
        if (stockSector === activeSector) {
          $(row).removeClass('hide');
        } else {
          $(row).addClass('hide');
        }
      })
    }

    function renderSectorOverviewChart(container, seriesData) {
        var options = {
          colors: ["#512da8","#283593","#ad1457","#1976d2","#4fc3f7","#009688","#757575","#212121"],
          chart: {
              type: 'bar'
          },
          title: {
              text: "Total Holdings By Sector",
              align: 'left',
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
              categories: ["Sector Breakdown"]
          },
          yAxis: {
              min: 0,
              labels: {
                enabled: false
              },
              title: {
                text: null
              }

          },
          legend: {
              reversed: true,
              itemStyle: {
                fontSize: "10px"
              },
              labelFormatter: function() {
                var valData = '$'+ Math.floor(this.yData[this.yData.length - 1]).toLocaleString();
                return this.name + " " + valData;
              },
              itemWidth:240
          },
          plotOptions: {
              series: {
                  stacking: 'normal',
                  dataLabels: {
                    enabled: true,
                    formatter: formatPct
                  }
              }
          },
          series: []
        };

        var total_value = 0;
        $.each(seriesData, function(key, value) {
          var s = {
            name: key,
            data: [value],
            pointWidth: 100
          };
          total_value += value;
          options.series.push(s);
        })
        options.yAxis.max = total_value;

        function formatPct() {
          var pcnt = (this.y/total_value) * 100;
          return Highcharts.numberFormat(pcnt)+"%";
        };

        container.highcharts(options);        
    }
})