import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

from orator.seeds import Seeder
import arrow
from helpers.get_portfolio_from_csv import get_portfolio_csv
import models.stock 
import models.user 
import models.stocks_portfolio
import models.portfolio 
import models.trade 


INDEX_DEFINITION = '../csvs/alpha_50.csv'

class ScroogeMcDuckSeeder(Seeder):

    def run(self):
        """
        Run the database seeds.
        """
        self.db.table('users').insert({
            'email': 'scrooge_mcduck@alpha50.com',
            'password_hash': '5678'})
        user = models.user.User.where('email', 'scrooge_mcduck@alpha50.com').first()
        user.portfolios().save(models.portfolio.Portfolio({'name': 'Alpha50', 'total_cash': 17.28, 'create_at'}))
        portfolio = models.portfolio.Portfolio.where('name', 'Alpha50').where('user_id', user.id).first()
        stocks = get_portfolio_csv(INDEX_DEFINITION)
        date_created = arrow.get('2009-01-01T01:00:00-07:00')
        
        for stock in stocks:
            stock_owner = models.stock.Stock.where('ticker', stock['ticker']).first()
            stocks_portfolio = models.stocks_portfolio.StocksPortfolio({'stock_id': stock_owner.id, 'portfolio_id': portfolio.id, 'quantity_held': stock['quantity']})
            stocks_portfolio.save()
            stocks_portfolio = models.stocks_portfolio.StocksPortfolio.where('stock_id', stock_owner.id).where('portfolio_id', portfolio.id).first()
            trade = models.trade.Trade({'stocks_portfolio_id': stocks_portfolio.id, 'quantity': stock['quantity'], 'price': stock['price']})
            trade.created_at = date_created
            trade.save()



