#!/usr/bin/env python3

import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

import arrow
from models.stock import Stock
from models.portfolio import Portfolio
from models.portfolio_valuation import PortfolioValuation

SECTORS = ['information_technology', 'energy', 'consumer_discretionary', 'health_care', 'industrials', 'telecommunications_services', 'financials', 'consumer_staples']

for portfolio in Portfolio.all():
    total_value = portfolio.total_cash
    portfolio_info = {}
    for sector in SECTORS:
        portfolio_info[sector] = 0
    portfolio_info['portfolio_id'] = portfolio.id
    for stock in portfolio.stocks_portfolios().get_results():
        market_stock = Stock.find(stock.stock_id)
        sector = market_stock.sector.lower().replace(' ', '_')
        if not market_stock.latest_price:
            market_stock.latest_price = 0
        total_value += market_stock.latest_price * stock.quantity_held
        portfolio_info[sector] += market_stock.latest_price * stock.quantity_held
    portfolio_info['portfolio_value'] = total_value
    portfolio_info['created_at'] = arrow.now('US/Pacific').format('YYYY-MM-DDTHH:mm:ss')
    PortfolioValuation.create(portfolio_info)



