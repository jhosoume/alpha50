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
        var preloader = $("#preloader").html();
        $('#portfolio-sector-chart').append(preloader).trigger('preloading');
        valuationsRequest = $.ajax({
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
})