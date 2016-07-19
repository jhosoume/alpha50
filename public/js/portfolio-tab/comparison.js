$(function() {
  $('#comparison-tab').bind('tabactive', function() {
    distributeColumns();


    function distributeColumns() {
      var table = $('table.return-comparison');
      console.log(table);
      var tableWidth = table.width();
      var headCells = table.children('thead').children('tr').children('th:nth-child(n+2)');
      headCells.each(function(idx,cell) {
        $(cell).width(tableWidth/4);
      })
    }
  })
})