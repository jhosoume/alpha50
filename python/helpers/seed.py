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

def create_portfolio(user, portfolio_name, cash, creation_date):
    pass

def create_stocks_portfolios(stocks_portfolios_path):
    pass

def create_trades():
    pass

def seed():
    pass


