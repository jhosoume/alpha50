$(function() {
  $('#comparison-tab').bind('tabactive', function() {
    distributeColumns();


    function distributeColumns() {
      var returnsTable = $('table.return-comparison');
      var rTableWidth = returnsTable.width();
      var rHeadCells = returnsTable.children('thead').children('tr').children('th');
      rHeadCells.each(function(idx,cell) {
        $(cell).width(rTableWidth/4);
      })

      var holdingsTable = $('table.holdings-comparison');
      var hTableWidth = holdingsTable.width();
      $('td.stock-ticker').css('width',hTableWidth/4+'px');
      $('td.index-weight').css('width',hTableWidth/4+'px');
    }
  })
})