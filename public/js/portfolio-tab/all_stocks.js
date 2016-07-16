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
		var cash = $('#all-stocks-tab').find('.cash').data("cash");

		var validateRow = function(stockRow, tradeType, numberOwned, numberTrading) {
			var button = $("#all-stocks-tab button");
				button.removeClass('disabled');
				button.text('Checkout');

			$(stockRow).removeClass('red');
			var valid = true;

			if (tradeType === 'BUY') {
				if (cash < totalBuySum) {
					valid = false;
				}
			} else {
				if (numberOwned < numberTrading) {
					valid = false;
				}
			}

			if (!valid) {
				$(stockRow).addClass('red lighten-1');
					button.addClass('disabled');
					button.text('Disabled');
			}
		}

	  	portfolioTableData.children().each(function(idx,stockRow) {
	  		var numberOwned = parseInt($(stockRow).children('td.shares-number').text());
			var numberTrading = parseInt($(stockRow).children('td.trade-quantity').children('input').val());
			// Validate that the number can't be less than 0
			if (numberTrading < 0 || isNaN(numberTrading)) numberTrading = 0;

			var sharePrice = parseFloat($(stockRow).children('td.stock-price').text());
			var tradeType = $(stockRow).children('td.trade-type').find('input').val();
			var totalValue = numberTrading * sharePrice;
			var subTotal = (sharePrice * numberTrading).toFixed(2);
			$(stockRow).children('.sub-total').text('$' + subTotal);

			if (tradeType === 'BUY') {
				// Validate that the user has enough money.
				totalBuySum += totalValue;
				validateRow(stockRow, tradeType, numberOwned, numberTrading);
			} else {
				// Validate that user can't short.
				totalSellSum += totalValue;
				validateRow(stockRow, tradeType, numberOwned, numberTrading);
			}
		});

	  	var equity = $('#all-stocks-tab').find('.equity').data("equity");
	  	var value = $('#all-stocks-tab').find('.value').data("value");
	   	var netCash = totalSellSum - totalBuySum;

	    $('.all-stocks-checkout').find('.buyingMoney').text("$"+ totalBuySum.toFixed(2));
	    $('.all-stocks-checkout').find('.sellingMoney').text("$"+ totalSellSum.toFixed(2));
	    $('.all-stocks-checkout').find('.netMoney').text("$"+ netCash.toFixed(2));
		$('.all-stocks-checkout').find('.adjustedCash').text("$"+ (cash + netCash).toFixed(2));
		$('.all-stocks-checkout').find('.adjustedEquity').text("$"+ (equity - netCash).toFixed(2));
	}

	$('#all-stocks-tab tbody').on('keyup', '.trade-quantity > input', calculateTotalTradeValue);
	$('#all-stocks-tab tbody').on('change', '.trade-type', calculateTotalTradeValue);
	$('#all-stocks-tab tbody').on('change','.trade-quantity > input', calculateTotalTradeValue);

	$("#all-stocks-tab form").on('submit', function(e) {
		var button = $("#all-stocks-tab button");
		if ($(button).hasClass('disabled')) {
			e.preventDefault();
		}
	});
	
});