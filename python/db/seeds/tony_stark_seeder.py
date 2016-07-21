import os, sys, inspect
currentdir = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0,parentdir)

from orator.seeds import Seeder
import arrow
from helpers.seed import seed
import models.user 


STOCKS_PORTFOLIOS_DEFINITION = '../csvs/tony_stark/stock_portfolio.csv'
TRADES_DEFINITION = '../csvs/tony_stark/trades.csv'
VALUATIONS_DEFINITION = '../csvs/tony_stark/portfolio_values.csv'
PORTFOLIO_CREATION_DATE = arrow.get('2016-01-20T10:00:00-07:00')
TOTAL_CASH = 31014.73
USER_EMAIL = 'tony_stark@alpha50.com'
PORTFOLIO_NAME = 'Tech-Finance'

HAS_MONKEY = True
MONKEY_STOCKS_PORTFOLIOS_DEFINITION = '../csvs/tony_stark/monkey_stock_portfolio.csv'
MONKEY_TRADES_DEFINITION = '../csvs/tony_stark/monkey_trades.csv'
MONKEY_VALUATIONS_DEFINITION = '../csvs/tony_stark/monkey_portfolio_values.csv'
MONKEY_PORTFOLIO_CREATION_DATE = arrow.get('2016-01-20T10:00:00-07:00')
MONKEY_TOTAL_CASH = 2385.04

class TonyStarkSeeder(Seeder):

    def run(self):
        """
        Run the database seeds.
        """
        self.db.table('users').insert({
            'email': USER_EMAIL,
            'password_hash': '$2y$10$NaKhKaHQDzpyYb0IwfBb5uLNKTHx8EHQZK5G6AjTaerCmbUvuil5C'})
        user = models.user.User.where('email', USER_EMAIL).first()
        seed(user, PORTFOLIO_NAME, TOTAL_CASH, PORTFOLIO_CREATION_DATE, STOCKS_PORTFOLIOS_DEFINITION, TRADES_DEFINITION, VALUATIONS_DEFINITION, MONKEY_TOTAL_CASH, MONKEY_PORTFOLIO_CREATION_DATE, MONKEY_STOCKS_PORTFOLIOS_DEFINITION, MONKEY_TRADES_DEFINITION, MONKEY_VALUATIONS_DEFINITION)
