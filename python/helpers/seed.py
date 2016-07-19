import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

import arrow
from helpers.get_stocks_portfolios import get_stocks_portfolios
from helpers.get_valuations import get_portfolio_valuations
from helpers.get_trades import get_trades
import models.stock
import models.user
import models.stocks_portfolio
import models.portfolio
import models.trade
import models.portfolio_valuation

def create_portfolio(user, portfolio_name, cash, creation_date, portfolio_parent = None):
    if portfolio_parent:
        user.portfolios().save(models.portfolio.Portfolio({'name': portfolio_name, 'total_cash': cash, 'created_at': creation_date.format('YYYY-MM-DDTHH:mm:ss'), 'parent': portfolio_parent.id}))
        return models.portfolio.Portfolio.where('name', portfolio_name).where('user_id', user.id).first()
    else:
        user.portfolios().save(models.portfolio.Portfolio({'name': 'Monkey' + portfolio_name, 'total_cash': cash, 'created_at': creation_date.format('YYYY-MM-DDTHH:mm:ss')}))
        return models.portfolio.Portfolio.where('name', portfolio_name).where('user_id', user.id).first()

def create_stocks_portfolios(portfolio, stocks_portfolios_path):
    for stock in get_stocks_portfolios(stocks_portfolios_path):
        stock_ticker = models.stock.Stock.where('ticker', stock['ticker']).first()
        models.stocks_portfolio.StocksPortfolio.create({'stock_id': stock_ticker.id, 'portfolio_id': portfolio.id, 'quantity_held': stock['quantity']})

def create_trades(portfolio, trades_path):
     for trade in get_trades(trades_path):
        stock = models.stock.Stock.where('ticker', trade['ticker']).first()
        stocks_portfolio = models.stocks_portfolio.StocksPortfolio.where('stock_id', stock.id).where('portfolio_id', portfolio.id).first()
        trade['stocks_portfolio_id'] = stocks_portfolio.id
        models.trade.Trade.create(trade)

def create_valuations(portfolio, valuation_path):
    for valuation in get_portfolio_valuations(valuation_path):
        valuation['portfolio_id'] = portfolio.id
        models.portfolio_valuation.PortfolioValuation.create(valuation)

def seed(user, portfolio_name, cash, creation_date, stocks_portfolios_path, trades_path, valuation_path, monkey_cash, monkey_creation_date, monkey_stocks_portfolios_path, monkey_trades_path, mokey_valuations_path):
    portfolio = create_portfolio(user, portfolio_name, cash, creation_date)
    create_stocks_portfolios(portfolio, stocks_portfolios_path)
    create_trades(portfolio, trades_path)
    create_valuations(portfolio, valuation_path)
    monkey_portfolio = create_portfolio(user, 'Monkey' + portfolio_name, monkey_cash, monkey_creation_date, portfolio)
    create_stocks_portfolio(monkey_portfolio, monkey_stocks_portfolios_path)
    create_trades(monkey_portfolio, monkey_trades_path)
    create_valuations(monkey_portfolio, monkey_valuations_path)

