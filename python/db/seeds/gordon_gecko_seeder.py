import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

import arrow
from orator.seeds import Seeder
from helpers.seed import seed
import models.user

STOCKS_PORTFOLIOS_DEFINITION = '../csvs/gordon_gecko/stock_portfolio.csv'
TRADES_DEFINITION = '../csvs/gordon_gecko/trades.csv'
VALUATIONS_DEFINITION = '../csvs/gordon_gecko/portfolio_values.csv'
PORTFOLIO_CREATION_DATE = arrow.get('2015-09-29T16:00:00-07:00')
TOTAL_CASH = 263.05
USER_EMAIL = 'gordon_gecko@alpha50.com'
PORTFOLIO_NAME = 'DoughGreenies (GOOGL, AMZN)'

MONKEY_STOCKS_PORTFOLIOS_DEFINITION = '../csvs/gordon_gecko/monkey_stock_portfolio.csv'
MONKEY_TRADES_DEFINITION = '../csvs/gordon_gecko/monkey_trades.csv'
MONKEY_VALUATIONS_DEFINITION = '../csvs/gordon_gecko/monkey_portfolio_values.csv'
MONKEY_PORTFOLIO_CREATION_DATE = arrow.get('2015-09-29T16:00:00-07:00')
MONKEY_TOTAL_CASH = 3392.41

class GordonGeckoSeeder(Seeder):

    def run(self):
        """
        Run the database seeds.
        """
        #self.db.table('users').insert({
            #'email': USER_EMAIL,
            #'password_hash': '$2y$10$gVV3obnlOHVflY2/nXb3CuqWY1/EveH5nGl0fmxdpY4Z.vA3UH5zm'})
        user = models.user.User.where('email', 'tony_stark@alpha50.com').first()
        seed(user, PORTFOLIO_NAME, TOTAL_CASH, PORTFOLIO_CREATION_DATE, STOCKS_PORTFOLIOS_DEFINITION, TRADES_DEFINITION, VALUATIONS_DEFINITION, MONKEY_TOTAL_CASH, MONKEY_PORTFOLIO_CREATION_DATE, MONKEY_STOCKS_PORTFOLIOS_DEFINITION, MONKEY_TRADES_DEFINITION, MONKEY_VALUATIONS_DEFINITION)
