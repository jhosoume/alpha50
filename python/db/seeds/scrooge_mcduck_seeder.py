import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

import arrow
from orator.seeds import Seeder
from helpers.seed import seed
import models.user


STOCKS_PORTFOLIOS_DEFINITION = '../csvs/scrooge_mcduck/stock_portfolio_15_07_16.csv'
TRADES_DEFINITION = '../csvs/scrooge_mcduck/trades.csv'
VALUATIONS_DEFINITION = '../csvs/scrooge_mcduck/portfolio_values.csv'
PORTFOLIO_CREATION_DATE = arrow.get('2012-04-16T16:00:00-07:00')
TOTAL_CASH = 17.28
USER_EMAIL = 'scrooge_mcduck@alpha50.com'
PORTFOLIO_NAME = 'GreatestHit'

MONKEY_STOCKS_PORTFOLIOS_DEFINITION = '../csvs/scrooge_mcduck/monkey_stock_portfolio_15_07_16.csv'
MONKEY_TRADES_DEFINITION = '../csvs/scrooge_mcduck/monkey_trades.csv'
MONKEY_VALUATIONS_DEFINITION = '../csvs/scrooge_mcduck/monkey_portfolio_values.csv'
MONKEY_PORTFOLIO_CREATION_DATE = arrow.get('2012-04-16T16:00:00-07:00')
MONKEY_TOTAL_CASH = 2917.71

class ScroogeMcduckSeeder(Seeder):

    def run(self):
        """
        Run the database seeds.
        """
        #self.db.table('users').insert({
            #'email': USER_EMAIL,
            #'password_hash': '$2y$10$6sbYRt2t42AOZdn6cm0sF.Pauifj3E466i9Fix6KCIbkqejXSsZfm'})
        user = models.user.User.where('email', 'tony_stark@alpha50.com').first()
        seed(user, PORTFOLIO_NAME, TOTAL_CASH, PORTFOLIO_CREATION_DATE, STOCKS_PORTFOLIOS_DEFINITION, TRADES_DEFINITION, VALUATIONS_DEFINITION, MONKEY_TOTAL_CASH, MONKEY_PORTFOLIO_CREATION_DATE, MONKEY_STOCKS_PORTFOLIOS_DEFINITION, MONKEY_TRADES_DEFINITION, MONKEY_VALUATIONS_DEFINITION)

