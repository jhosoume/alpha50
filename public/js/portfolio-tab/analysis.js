$(function () {
  $('#analysis-tab')
    .bind('tabactive', function() {
      $('select').material_select();
      selectSector();
      sectorOverviewChart();
    })
    .on('change','#sector-filter', function () {
      selectSector();
      sectorOverviewChart();
    })

    function sectorOverviewChart() {
        var activeSector = $('#sector-filter').val();
        valuationsRequest = $.ajax({
          url: "/api" + window.location.pathname,
          method: 'GET',
          data: {'request_type': 'historical_valuation', 'sector':activeSector},
          contentType: 'JSON'
        });
        valuationsRequest.then(function(valuations) {
          //the following two functions can be found in overview.js
          var chartArray = createChartArray(valuations);
          renderPerformanceChart(chartArray, $("#sector-overview-chart"));
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
})