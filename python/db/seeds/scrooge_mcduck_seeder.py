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


STOCKS_PORTFOLIOS_DEFINITION = '../csvs/scrooge_mcduck/stock_portfolio_15_07_16.csv'
TRADES_DEFINITION = '../csvs/scrooge_mcduck/trades.csv'
VALUATIONS_DEFINITION = '../csvs/scrooge_mcduck/portfolio_values.csv'
PORTFOLIO_CREATION_DATE = arrow.get('2012-04-16T16:00:00-07:00')
TOTAL_CASH = 17.28
USER_EMAIL = 'scrooge_mcduck@alpha50.com'
PORTFOLIO_NAME = 'GreatestHit'

class ScroogeMcDuckSeeder(Seeder):

    def run(self):
        """
        Run the database seeds.
        """
        self.db.table('users').insert({
            'email': USER_EMAIL,
            'password_hash': '5678'})
        user = models.user.User.where('email', USER_EMAIL).first()
        user.portfolios().save(models.portfolio.Portfolio({'name': PORTFOLIO_NAME, 'total_cash': TOTAL_CASH, 'created_at': PORTFOLIO_CREATION_DATE.format('YYYY-MM-DDTHH:mm:ss')}))
        portfolio = models.portfolio.Portfolio.where('name', 'GreatestHit').where('user_id', user.id).first()
        for stock in get_stocks_portfolios(STOCKS_PORTFOLIOS_DEFINITION):
            stock_owner = models.stock.Stock.where('ticker', stock['ticker']).first()
            models.stocks_portfolio.StocksPortfolio.create({'stock_id': stock_owner.id, 'portfolio_id': portfolio.id, 'quantity_held': stock['quantity']})

        for trade in get_trades(TRADES_DEFINITION):
            stock = models.stock.Stock.where('ticker', trade['ticker']).first()
            stocks_portfolio = models.stocks_portfolio.StocksPortfolio.where('stock_id', stock.id).where('portfolio_id', portfolio.id).first()
            trade['stocks_portfolio_id'] = stocks_portfolio.id
            models.trade.Trade.create(trade)

        for valuation in get_portfolio_valuations(VALUATIONS_DEFINITION):
            valuation['portfolio_id'] = portfolio.id
            models.portfolio_valuation.PortfolioValuation.create(valuation)





