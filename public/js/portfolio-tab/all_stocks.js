$(function() {

	$("#all-stocks-tab").find('select').material_select();
	$("#all-stocks-tab").find(".select-wrapper").css('width','60px')
	var portfolioTableData = $('#all-stocks-tab tbody');
	var totalBuySum;
	var totalSellSum;

	calculateTotalTradeValue();

	function calculateTotalTradeValue() {
		totalBuySum = 0;
		totalSellSum = 0;
	  	portfolioTableData.children().each(function(idx,stockRow) {
			var numberTrading = $(stockRow).children('td.trade-quantity').children('input').val();
			var sharePrice = $(stockRow).children('td.stock-price').text();
			var tradeType = $(stockRow).children('td.trade-type').find('.select-dropdown').val();
			var totalValue = numberTrading * sharePrice;
			$(stockRow).children('.sub-total').text('$' + (sharePrice * numberTrading));

			if (tradeType === 'BUY') {
				totalBuySum += totalValue;
			} else {
				totalSellSum += totalValue;
			}
		});

	  	var equity = $('#all-stocks-tab').find('.equity').data("equity");
	  	var value = $('#all-stocks-tab').find('.value').data("value");
		var cash = $('#all-stocks-tab').find('.cash').data("cash");
	   	var netCash = totalSellSum - totalBuySum;

	    $('.all-stocks-checkout').find('.buyingMoney').text("$"+ totalBuySum);
	    $('.all-stocks-checkout').find('.sellingMoney').text("$"+ totalSellSum);
	    $('.all-stocks-checkout').find('.netMoney').text("$"+ netCash);
		$('.all-stocks-checkout').find('.adjustedCash').text("$"+ (cash + netCash));
		$('.all-stocks-checkout').find('.adjustedEquity').text("$"+ (equity - netCash));
	}

	$('#all-stocks-tab tbody').on('change','.trade-quantity > input', function() {
	    calculateTotalTradeValue();
	});




});