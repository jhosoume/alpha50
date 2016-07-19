import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

from orator.seeds import Seeder
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


STOCKS_PORTFOLIOS_DEFINITION = '../csvs/jay_gatsby/stock_portfolio.csv'
TRADES_DEFINITION = '../csvs/jay_gatsby/trades.csv'
VALUATIONS_DEFINITION = '../csvs/jay_gatsby/portfolio_values.csv'
PORTFOLIO_CREATION_DATE = arrow.get('2016-03-18T10:00:00-07:00')
TOTAL_CASH = 66.02
USER_EMAIL = 'jay_gatsby@alpha50.com'
PORTFOLIO_NAME = 'RichestPortfolio'

HAS_MONKEY = True
MONKEY_STOCKS_PORTFOLIOS_DEFINITION = '../csvs/jay_gatsby/monkey_stock_portfolio.csv'
MONKEY_TRADES_DEFINITION = '../csvs/jay_gatsby/monkey_trades.csv'
MONKEY_VALUATIONS_DEFINITION = '../csvs/jay_gatsby/monkey_portfolio_values.csv'
MONKEY_PORTFOLIO_CREATION_DATE = arrow.get('2016-03-18T10:00:00-07:00')
MONKEY_TOTAL_CASH = 1160.56

class JayGatsbySeeder(Seeder):

    def run(self):
        """
        Run the database seeds.
        """
        self.db.table('users').insert({
            'email': USER_EMAIL,
            'password_hash': '5678'})
        user = models.user.User.where('email', USER_EMAIL).first()
        user.portfolios().save(models.portfolio.Portfolio({'name': PORTFOLIO_NAME, 'total_cash': TOTAL_CASH, 'created_at': PORTFOLIO_CREATION_DATE.format('YYYY-MM-DDTHH:mm:ss')}))
        portfolio = models.portfolio.Portfolio.where('name', PORTFOLIO_NAME).where('user_id', user.id).first()
        for stock in get_stocks_portfolios(STOCKS_PORTFOLIOS_DEFINITION):
            stock_owner = models.stock.Stock.where('ticker', stock['ticker']).first()
            models.stocks_portfolio.StocksPortfolio.create({'stock_id': stock_owner.id, 'portfolio_id': portfolio.id, 'quantity_held': stock['quantity']})
    
        for trade in get_trades(TRADES_DEFINITION):
            if trade['quantity'] != 0:
                stock = models.stock.Stock.where('ticker', trade['ticker']).first()
                stocks_portfolio = models.stocks_portfolio.StocksPortfolio.where('stock_id', stock.id).where('portfolio_id', portfolio.id).first()
                trade['stocks_portfolio_id'] = stocks_portfolio.id
                models.trade.Trade.create(trade)

        for valuation in get_portfolio_valuations(VALUATIONS_DEFINITION):
            valuation['portfolio_id'] = portfolio.id
            val = models.portfolio_valuation.PortfolioValuation.create(valuation)

        if HAS_MONKEY:
            user.portfolios().save(models.portfolio.Portfolio({'name': 'Monkey' + PORTFOLIO_NAME, 'total_cash': MONKEY_TOTAL_CASH, 'created_at': MONKEY_PORTFOLIO_CREATION_DATE.format('YYYY-MM-DDTHH:mm:ss'), 'parent': portfolio.id}))
            monkey_portfolio = models.portfolio.Portfolio.where('name', 'Monkey' + PORTFOLIO_NAME).where('user_id', user.id).first()
            for stock in get_stocks_portfolios(MONKEY_STOCKS_PORTFOLIOS_DEFINITION):
                stock_owner = models.stock.Stock.where('ticker', stock['ticker']).first()
                models.stocks_portfolio.StocksPortfolio.create({'stock_id': stock_owner.id, 'portfolio_id': monkey_portfolio.id, 'quantity_held': stock['quantity']})

            for trade in get_trades(TRADES_DEFINITION):
                if trade['quantity'] != 0:
                    stock = models.stock.Stock.where('ticker', trade['ticker']).first()
                    stocks_portfolio = models.stocks_portfolio.StocksPortfolio.where('stock_id', stock.id).where('portfolio_id', monkey_portfolio.id).first()
                    trade['stocks_portfolio_id'] = stocks_portfolio.id
                    models.trade.Trade.create(trade)

            for valuation in get_portfolio_valuations(VALUATIONS_DEFINITION):
                valuation['portfolio_id'] = monkey_portfolio.id
                models.portfolio_valuation.PortfolioValuation.create(valuation)



