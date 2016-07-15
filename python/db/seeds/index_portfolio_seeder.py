import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

from orator.seeds import Seeder
from helpers.get_portfolio_from_csv import get_portfolio_csv
import models.stock 
import models.user 
import models.stocks_portfolio
import models.portfolio 
import models.trade 


INDEX_DEFINITION = '../csvs/alpha_50.csv'

class IndexPortfolioSeeder(Seeder):

    def run(self):
        """
        Run the database seeds.
        """
        self.db.table('users').insert({
            'email': 'admin@alpha50',
            'password_hash': '1234'})
        user = models.user.User.where('email', 'admin@alpha50').first()
        models.user.User.where('email', 'admin@alpha50').first().portfolios().save(models.portfolio.Portfolio({'name': 'Alpha50', 'cash': 0.0}))
        portfolio = models.portfolio.Portfolio.where('name', 'Alpha50').where('user_id', user.id).first()
        stocks = get_portfolio_csv(INDEX_DEFINITION)
        
        for stock in stocks:
            #import pdb; pdb.set_trace()
            stock_id = models.stock.Stock.where('ticker', stock['ticker']).first()
            stocks_portfolio = models.stocks_portfolio.StocksPortfolio({'stock_id': stock_id.id, 'portfolio_id': portfolio.id, 'quantity_held': stock['quantity']})
            stocks_portfolio.save()
            #stocks_portfolio.trades().save(models.trade.Trade())



